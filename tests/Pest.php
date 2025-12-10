<?php

declare(strict_types=1);

/**
 * Helper function to create a Pest dataset from a model dataset class.
 *
 * @param string $datasetClass The fully qualified class name of the dataset class (e.g., AlbertDataset::class)
 */
function modelTokenizationDataset(string $datasetClass, bool $withTextPair = false): Closure
{
    return function () use ($datasetClass, $withTextPair) {
        if (!class_exists($datasetClass) || !method_exists($datasetClass, 'data')) {
            return;
        }

        $data = $datasetClass::data();

        foreach ($data as $modelId => $testCases) {
            foreach ($testCases as $caseName => $caseData) {
                $data = [
                    'modelId' => $modelId,
                    'text' => $caseData['text'],
                    'expectedTokens' => $caseData['tokens'],
                    'expectedIds' => $caseData['ids'],
                    'expectedDecoded' => $caseData['decoded'],
                ];

                if ($withTextPair) {
                    $data['textPair'] = $caseData['text_pair'] ?? null;
                }

                yield "{$modelId} - {$caseName}" => $data;
            }
        }
    };
}
