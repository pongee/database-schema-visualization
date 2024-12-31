<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Command\Mysql;

use Pongee\DatabaseSchemaVisualization\Export\Plantuml;
use Pongee\DatabaseSchemaVisualization\Generator\ImageGenerator;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MysqlImageCommand extends MysqlCommandAbstract
{
    protected const OPTION_TEMPLATE = 'template';
    protected const OPTION_TYPE = 'type';
    protected const DEFAULT_TEMPLATE = 'src/Template/Plantuml/v1.twig';
    protected const DEFAULT_TYPE = 'png';
    protected const PLANTUML_BIN = 'bin/plantuml.jar';
    protected const TEMP_DIR = 'tmp';
    protected const ALLOWED_IMAGE_TYPES = ['png', 'svg'];

    protected function configure(): void
    {
        $this
            ->setName('mysql:image')
            ->setDescription('Generate mysql schema dump as Plantuml diagram.')
            ->addOption(
                self::OPTION_TEMPLATE,
                't',
                InputOption::VALUE_OPTIONAL,
                '',
                self::DEFAULT_TEMPLATE
            )
            ->addOption(
                self::OPTION_TYPE,
                'it',
                InputOption::VALUE_OPTIONAL,
                '',
                self::DEFAULT_TYPE
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sqlFileContent = $this->getSqlFileContent($input);
        $templateFileContent = $this->getTemplateFileContent($input);

        $generatedPlantuml = (new Plantuml($templateFileContent))->export(
            $this->parser->run(
                $sqlFileContent,
                $this->getForcedConnections($input->getOption(self::OPTION_CONNECTION))
            )
        );

        $image = new ImageGenerator(
            $this->getImageType($input),
            $this->rootDir . self::PLANTUML_BIN,
            $this->rootDir . self::TEMP_DIR
        );

        echo $image->generate($generatedPlantuml);

        return 0;
    }

    protected function getTemplateFileContent(InputInterface $input): string
    {
        $templateFilePath = $this->rootDir . $input->getOption(self::OPTION_TEMPLATE);

        if (!is_file($templateFilePath)) {
            throw new RuntimeException(sprintf('Bad template file path. [%s] is not a file', $templateFilePath));
        }

        if (!is_readable($templateFilePath)) {
            throw new RuntimeException(sprintf('Bad template file path. [%s] is unreadable.', $templateFilePath));
        }

        return file_get_contents($templateFilePath);
    }

    protected function getImageType(InputInterface $input): string
    {
        $imageType = $input->getOption(self::OPTION_TYPE);

        if (!in_array($imageType, static::ALLOWED_IMAGE_TYPES, true)) {
            throw new RuntimeException(
                sprintf(
                    'Not allowed image type. Allowed: [%s]',
                    implode(',', self::ALLOWED_IMAGE_TYPES)
                )
            );
        }

        return $imageType;
    }
}
