<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Generator;

use DateTime;
use Exception;
use RuntimeException;
use SplFileObject;
use Twig\Environment;

final readonly class ImageGenerator
{
    private const int PLANTUML_LIMIT_SIZE = 16384;

    public function __construct(
        private string $imageType,
        private string $plantumlJarPath,
        private string $outputFolder
    ) {
    }

    /**
     * @throws Exception
     */
    public function generate(string $plantuml): string
    {
        $fileName = sprintf('plantuml-%s-%s', new DateTime()->format('Y-m-d-H-i-s-u'), mt_rand());

        $sourceFile = new SplFileObject($this->outputFolder . '/' . $fileName . '.puml', 'w');
        $sourceFile->fwrite($plantuml);

        $output = $this->generatePlantuml($sourceFile);

        try {
            $outputFile = new SplFileObject($this->outputFolder . '/' . $fileName . '.' . $this->imageType, 'r');
        } catch (RuntimeException $runtimeException) {
            $this->deleteFiles($sourceFile);

            throw new Exception(
                sprintf(
                    'Plantuml diagram generation failed. Original error: [%s] output: [%s]',
                    $runtimeException->getMessage(),
                    $output
                )
            );
        }

        $plantumlPng = $outputFile->fread($outputFile->getSize());

        $this->deleteFiles($sourceFile, $outputFile);

        return $plantumlPng;
    }

    private function generatePlantuml(SplFileObject $sourceFile): string
    {
        exec(
            sprintf(
                'java -DPLANTUML_LIMIT_SIZE=%s -jar %s %s -t%s -output %s 2>&1',
                self::PLANTUML_LIMIT_SIZE,
                $this->plantumlJarPath,
                $sourceFile->getRealPath(),
                escapeshellarg($this->imageType),
                $this->outputFolder
            ),
            $output,
            $return
        );

        return implode("\n", $output);
    }

    private function deleteFiles(SplFileObject ...$files): void
    {
        foreach ($files as $file) {
            unlink($file->getRealPath());
        }
    }
}
