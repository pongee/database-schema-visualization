<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Command;

use Pongee\DatabaseSchemaVisualization\Export\Plantuml;
use Pongee\DatabaseSchemaVisualization\Generator\ImageGenerator;
use Pongee\DatabaseSchemaVisualization\Generator\ImageType;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class ImageCommand extends CommandAbstract
{
    private const string OPTION_TYPE = 'type';

    private const string DEFAULT_TEMPLATE = 'src/Template/Plantuml/v1.twig';

    private const string DEFAULT_TYPE = ImageType::Png->value;

    private const string PLANTUML_BIN = 'bin/plantuml-mit-1.2026.6.jar';

    protected function configure(): void
    {
        $this
            ->setDescription('Generate the schema dump as an image.')
            ->addTemplateOption(self::DEFAULT_TEMPLATE)
            ->addOption(
                self::OPTION_TYPE,
                null,
                InputOption::VALUE_OPTIONAL,
                '',
                self::DEFAULT_TYPE
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $schema = $this->parseSchema($input);
        $generatedPlantuml = new Plantuml($this->getTemplateFileContent($input))->export($schema);

        $image = new ImageGenerator(
            $this->getImageType($input),
            $this->rootDir . self::PLANTUML_BIN
        );

        echo $image->generate($generatedPlantuml);

        return 0;
    }

    private function getImageType(InputInterface $input): ImageType
    {
        $imageType = ImageType::tryFrom((string) $input->getOption(self::OPTION_TYPE));

        if (!$imageType instanceof ImageType) {
            throw new RuntimeException(
                sprintf(
                    'Not allowed image type. Allowed: [%s]',
                    implode(',', array_column(ImageType::cases(), 'value'))
                )
            );
        }

        return $imageType;
    }
}
