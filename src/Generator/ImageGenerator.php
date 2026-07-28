<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Generator;

use Exception;

final readonly class ImageGenerator
{
    private const int PLANTUML_LIMIT_SIZE = 16384;

    public function __construct(
        private string $imageType,
        private string $plantumlJarPath
    ) {
    }

    /**
     * @throws Exception
     */
    public function generate(string $plantuml): string
    {
        $command = implode(' ', [
            'java',
            sprintf('-DPLANTUML_LIMIT_SIZE=%d', self::PLANTUML_LIMIT_SIZE),
            '-jar',
            escapeshellarg($this->plantumlJarPath),
            '--pipe',
            '--format',
            escapeshellarg($this->imageType),
        ]);

        $process = proc_open(
            $command,
            [
                0 => ['pipe', 'r'],
                1 => ['pipe', 'w'],
                2 => ['pipe', 'w'],
            ],
            $pipes
        );

        if (!is_resource($process)) {
            throw new Exception('Plantuml diagram generation failed. Unable to start the process.');
        }

        fwrite($pipes[0], $plantuml);
        fclose($pipes[0]);

        $image = stream_get_contents($pipes[1]);
        $error = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);

        if (proc_close($process) !== 0 || $image === false || $image === '') {
            throw new Exception(
                sprintf('Plantuml diagram generation failed. Original error: [%s]', $error)
            );
        }

        return $image;
    }
}
