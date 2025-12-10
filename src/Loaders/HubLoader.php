<?php

declare(strict_types=1);

namespace Codewithkyrian\Tokenizers\Loaders;

use Codewithkyrian\Tokenizers\Contracts\ConfigLoaderInterface;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriFactoryInterface;

class HubLoader implements ConfigLoaderInterface
{
    protected const HF_ENDPOINT = 'https://huggingface.co';
    protected const TOKENIZERS_VERSION = '0.1.0';

    protected ClientInterface $client;
    protected RequestFactoryInterface $requestFactory;
    protected UriFactoryInterface $uriFactory;

    protected ?string $resolvedCacheDir = null;

    public function __construct(
        protected ?string $cacheDir = null,
        protected ?string $revision = 'main',
        protected ?string $token = null
    ) {
        $this->client = Psr18ClientDiscovery::find();
        $this->requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $this->uriFactory = Psr17FactoryDiscovery::findUriFactory();
        $this->resolvedCacheDir = $this->resolveCacheDir();
    }

    public function load(string ...$source): array
    {
        if (0 === \count($source)) {
            throw new \Exception('A model ID must be provided.');
        }

        $modelId = $source[0];

        $encodedSource = implode('/', array_map('rawurlencode', explode('/', $modelId)));
        $encodedRevision = rawurlencode($this->revision);

        $tokenizerUrl = \sprintf(
            '%s/%s/resolve/%s/tokenizer.json',
            self::HF_ENDPOINT,
            $encodedSource,
            $encodedRevision
        );

        $tokenizerConfigUrl = \sprintf(
            '%s/%s/resolve/%s/tokenizer_config.json',
            self::HF_ENDPOINT,
            $encodedSource,
            $encodedRevision
        );

        $bundle = $this->loadFromBundleCache($tokenizerUrl, $tokenizerConfigUrl);
        if (null !== $bundle) {
            return $bundle;
        }

        [$tokenizerJson, $tokenizerPath, $tokenizerEtag] = $this->downloadJson($tokenizerUrl, 'tokenizer.json', $modelId);
        [$tokenizerConfig, $tokenizerConfigPath, $tokenizerConfigEtag] = $this->downloadJson($tokenizerConfigUrl, 'tokenizer_config.json', $modelId, optional: true);

        if (null !== $this->resolvedCacheDir) {
            $this->cacheBundle(
                $tokenizerUrl,
                $tokenizerPath,
                $tokenizerEtag,
                $tokenizerConfigUrl,
                $tokenizerConfigPath,
                $tokenizerConfigEtag
            );
        }

        return $this->mergeConfigs($tokenizerJson, $tokenizerConfig);
    }

    /**
     * Sends a request and follows HTTP redirects until a non-redirect response is received.
     *
     * @param RequestInterface $request      the initial request
     * @param int              $maxRedirects maximum number of redirects to follow (default: 5)
     *
     * @return ResponseInterface the final response after following redirects
     *
     * @throws \Exception if too many redirects occur or if a redirect fails
     */
    protected function sendRequest(RequestInterface $request, int $maxRedirects = 5): ResponseInterface
    {
        $redirectCount = 0;
        $currentRequest = $request;

        while ($redirectCount < $maxRedirects) {
            $response = $this->client->sendRequest($currentRequest);
            $statusCode = $response->getStatusCode();

            // Check if this is a redirect (3xx status code)
            if ($statusCode >= 300 && $statusCode < 400) {
                $location = $response->getHeaderLine('Location');
                if (empty($location)) {
                    throw new \Exception('Received redirect response without Location header');
                }

                if (preg_match('/^https?:\/\//', $location)) {
                    $parsed = parse_url($location);
                    if (false !== $parsed) {
                        $uri = $this->uriFactory->createUri()
                            ->withScheme($parsed['scheme'] ?? 'https')
                            ->withHost($parsed['host'] ?? '')
                            ->withPort($parsed['port'] ?? null)
                            ->withPath($parsed['path'] ?? '/')
                            ->withQuery($parsed['query'] ?? '')
                            ->withFragment($parsed['fragment'] ?? '')
                        ;

                        $currentRequest = $this->requestFactory->createRequest('GET', $uri);
                    } else {
                        $currentRequest = $this->requestFactory->createRequest('GET', $location);
                    }
                } else {
                    $parsed = parse_url($location);

                    $newUri = $currentRequest->getUri()
                        ->withQuery($parsed['query'] ?? '')
                        ->withFragment($parsed['fragment'] ?? '')
                    ;

                    $locationPath = $parsed['path'] ?? $location;

                    if (str_starts_with($location, '/')) {
                        $newUri = $newUri->withPath($locationPath);
                    } else {
                        $basePath = $newUri->getPath();
                        $basePath = '.' === \dirname($basePath) ? '/' : \dirname($basePath);
                        $newUri = $newUri->withPath(rtrim($basePath, '/').'/'.$locationPath);
                    }

                    $currentRequest = $this->requestFactory->createRequest('GET', $newUri);
                }

                $currentRequest = $currentRequest
                    ->withHeader('User-Agent', 'tokenizers/'.self::TOKENIZERS_VERSION.'; PHP')
                ;

                if ($this->token) {
                    $currentRequest = $currentRequest->withHeader('Authorization', "Bearer {$this->token}");
                }

                ++$redirectCount;

                continue;
            }

            return $response;
        }

        throw new \Exception("Too many redirects (max: {$maxRedirects})");
    }

    /**
     * Resolves the cache directory based on OS.
     *
     * @return null|string the cache directory path, or null if it cannot be determined
     */
    protected function resolveCacheDir(): ?string
    {
        if (null !== $this->cacheDir) {
            return $this->ensureCacheDir($this->cacheDir);
        }

        $envCache = getenv('TOKENIZERS_CACHE');
        if (false !== $envCache) {
            return $this->ensureCacheDir($envCache);
        }

        $baseDir = $this->getOSCacheBaseDir();
        if (null === $baseDir) {
            return null;
        }

        $cacheDir = $baseDir.\DIRECTORY_SEPARATOR.'huggingface'.\DIRECTORY_SEPARATOR.'tokenizers';

        return $this->ensureCacheDir($cacheDir);
    }

    /**
     * Gets the OS-specific base cache directory.
     *
     * @return null|string the base cache directory, or null if it cannot be determined
     */
    protected function getOSCacheBaseDir(): ?string
    {
        if (\PHP_OS_FAMILY === 'Windows') {
            $localAppData = getenv('LOCALAPPDATA');

            return false !== $localAppData ? $localAppData : null;
        }

        if (\PHP_OS_FAMILY === 'Darwin') {
            $home = getenv('HOME');

            return false !== $home ? $home.\DIRECTORY_SEPARATOR.'Library'.\DIRECTORY_SEPARATOR.'Caches' : null;
        }

        $xdgCache = getenv('XDG_CACHE_HOME');
        if (false !== $xdgCache) {
            return $xdgCache;
        }

        $home = getenv('HOME');

        return false !== $home ? $home.\DIRECTORY_SEPARATOR.'.cache' : null;
    }

    /**
     * Ensures the cache directory exists and returns the path.
     *
     * @param string $dir the directory path
     *
     * @return null|string the directory path, or null if it cannot be created
     */
    protected function ensureCacheDir(string $dir): ?string
    {
        if (!is_dir($dir)) {
            if (!@mkdir($dir, 0755, true) && !is_dir($dir)) {
                return null;
            }
        }

        return $dir;
    }

    /**
     * Gets the cached path for a URL if it exists and is valid.
     *
     * @param string $url the URL to check
     *
     * @return null|string the cached file path, or null if not cached or invalid
     */
    protected function getCachedPath(string $url): ?string
    {
        $fsum = hash('sha256', $url);
        $metaPattern = $this->resolvedCacheDir.\DIRECTORY_SEPARATOR.$fsum.'.*.meta';
        $metaFiles = glob($metaPattern);

        if (empty($metaFiles)) {
            return null;
        }

        $latestMeta = null;
        $latestTime = 0;
        foreach ($metaFiles as $metaFile) {
            $content = file_get_contents($metaFile);
            if (false === $content) {
                continue;
            }

            $meta = json_decode($content, true);
            if (null === $meta) {
                continue;
            }

            $creationTime = $meta['creation_time'] ?? 0;
            if ($creationTime > $latestTime) {
                $latestTime = $creationTime;
                $latestMeta = $meta;
            }
        }

        if (null === $latestMeta || !isset($latestMeta['resource_path'])) {
            return null;
        }

        $resourcePath = $latestMeta['resource_path'];
        if (!file_exists($resourcePath)) {
            return null;
        }

        // Trust the cache if file exists and metadata is valid
        // The etag-based filename (fsum.esum) provides uniqueness
        return $resourcePath;
    }

    /**
     * Attempt to load both tokenizer.json and tokenizer_config.json from a bundled cache entry.
     *
     * @return null|array<string, mixed>
     */
    protected function loadFromBundleCache(string $tokenizerUrl, string $tokenizerConfigUrl): ?array
    {
        if (null === $this->resolvedCacheDir) {
            return null;
        }

        $bundleKey = hash('sha256', $tokenizerUrl.'|'.$tokenizerConfigUrl);
        $metaPath = $this->resolvedCacheDir.\DIRECTORY_SEPARATOR.$bundleKey.'.bundle.meta';

        if (!file_exists($metaPath)) {
            return null;
        }

        $metaContent = file_get_contents($metaPath);
        if (false === $metaContent) {
            return null;
        }

        $meta = json_decode($metaContent, true);
        if (!\is_array($meta)) {
            return null;
        }

        $tokPath = $meta['tokenizer_path'] ?? null;
        $tokCfgPath = $meta['tokenizer_config_path'] ?? null;

        if (!$tokPath || !file_exists($tokPath)) {
            return null;
        }

        $tokenizerContent = file_get_contents($tokPath);
        if (false === $tokenizerContent) {
            return null;
        }

        $tokenizerJson = json_decode($tokenizerContent, true);
        if (\JSON_ERROR_NONE !== json_last_error()) {
            return null;
        }

        $tokenizerConfig = null;
        if ($tokCfgPath && file_exists($tokCfgPath)) {
            $tokenizerConfigContent = file_get_contents($tokCfgPath);
            if (false === $tokenizerConfigContent) {
                return null;
            }

            $tokenizerConfig = json_decode($tokenizerConfigContent, true);
            if (\JSON_ERROR_NONE !== json_last_error()) {
                $tokenizerConfig = null;
            }
        }

        return $this->mergeConfigs($tokenizerJson, $tokenizerConfig);
    }

    /**
     * Download a JSON resource, using cache when available.
     *
     * @param bool $optional treat 404 as optional
     *
     * @return array{0: null|array<string, mixed>, 1: null|string, 2: null|string} [json, path, etag]
     *
     * @throws \Exception
     */
    protected function downloadJson(string $url, string $label, string $source, bool $optional = false): array
    {
        // Try cache for this resource
        $cachedPath = $this->resolvedCacheDir ? $this->getCachedPath($url) : null;
        if (null !== $cachedPath && file_exists($cachedPath)) {
            $cachedContent = file_get_contents($cachedPath);
            if (false === $cachedContent) {
                return [null, null, null];
            }

            $json = json_decode($cachedContent, true);
            if (\JSON_ERROR_NONE === json_last_error()) {
                return [$json, $cachedPath, null];
            }
        }

        $request = $this->requestFactory->createRequest('GET', $url)
            ->withHeader('User-Agent', 'tokenizers/'.self::TOKENIZERS_VERSION.'; PHP')
        ;

        if ($this->token) {
            $request = $request->withHeader('Authorization', "Bearer {$this->token}");
        }

        try {
            $response = $this->sendRequest($request);
        } catch (\Exception $e) {
            throw new \Exception("Failed to load {$label} from Hub for model {$source}: ".$e->getMessage(), 0, $e);
        }

        $status = $response->getStatusCode();
        if ($optional && 404 === $status) {
            return [null, null, null];
        }

        $content = (string) $response->getBody();
        if (200 !== $status) {
            throw new \Exception("Failed to load {$label} from Hub for model {$source}: ".$content);
        }

        $json = json_decode($content, true);
        if (\JSON_ERROR_NONE !== json_last_error()) {
            throw new \Exception("Invalid JSON in {$label} from {$source}: ".json_last_error_msg());
        }

        $etag = $response->getHeaderLine('ETag') ?: null;
        $path = null;

        if (null !== $this->resolvedCacheDir && null !== $etag) {
            $path = $this->cacheResponse($url, $content, $etag);
        }

        return [$json, $path, $etag];
    }

    /**
     * Cache a response with a provided ETag, returning the resource path.
     */
    protected function cacheResponse(string $url, string $content, string $etag): ?string
    {
        $fsum = hash('sha256', $url);
        $esum = hash('sha256', $etag);
        $resourcePath = $this->resolvedCacheDir.\DIRECTORY_SEPARATOR.$fsum.'.'.$esum;
        $metaPath = $resourcePath.'.meta';
        $lockPath = $resourcePath.'.lock';

        file_put_contents($lockPath, '');

        try {
            file_put_contents($resourcePath, $content);

            $meta = [
                'resource' => $url,
                'resource_path' => $resourcePath,
                'meta_path' => $metaPath,
                'etag' => $etag,
                'expires' => null,
                'creation_time' => microtime(true),
            ];

            file_put_contents($metaPath, json_encode($meta, \JSON_PRETTY_PRINT));
        } finally {
            if (file_exists($lockPath)) {
                unlink($lockPath);
            }
        }

        return $resourcePath;
    }

    /**
     * Cache a bundle (tokenizer.json + tokenizer_config.json) into a single meta file.
     */
    protected function cacheBundle(
        string $tokenizerUrl,
        ?string $tokenizerPath,
        ?string $tokenizerEtag,
        string $tokenizerConfigUrl,
        ?string $tokenizerConfigPath,
        ?string $tokenizerConfigEtag
    ): void {
        if (null === $this->resolvedCacheDir) {
            return;
        }

        $bundleKey = hash('sha256', $tokenizerUrl.'|'.$tokenizerConfigUrl);
        $metaPath = $this->resolvedCacheDir.\DIRECTORY_SEPARATOR.$bundleKey.'.bundle.meta';

        $meta = [
            'tokenizer_url' => $tokenizerUrl,
            'tokenizer_path' => $tokenizerPath,
            'tokenizer_etag' => $tokenizerEtag,
            'tokenizer_config_url' => $tokenizerConfigUrl,
            'tokenizer_config_path' => $tokenizerConfigPath,
            'tokenizer_config_etag' => $tokenizerConfigEtag,
            'creation_time' => microtime(true),
        ];

        file_put_contents($metaPath, json_encode($meta, \JSON_PRETTY_PRINT));
    }

    /**
     * Merge tokenizer.json with tokenizer_config.json (config wins).
     *
     * @param null|array<string, mixed> $tokenizer
     * @param null|array<string, mixed> $tokenizerConfig
     *
     * @return array<string, mixed>
     */
    protected function mergeConfigs(?array $tokenizer, ?array $tokenizerConfig): array
    {
        $tokenizer ??= [];
        $tokenizerConfig ??= [];

        return array_merge($tokenizer, $tokenizerConfig);
    }
}
