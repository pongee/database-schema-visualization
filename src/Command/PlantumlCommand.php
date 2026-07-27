<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Command;

use Pongee\DatabaseSchemaVisualization\Export\Plantuml;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class PlantumlCommand extends CommandAbstract
{
    private const string DEFAULT_TEMPLATE = 'src/Template/Plantuml/v2.twig';

    protected function configure(): void
    {
        $this
            ->setDescription('Generate the schema dump as a Plantuml diagram.')
            ->addTemplateOption(self::DEFAULT_TEMPLATE);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $schema = $this->parseSchema($input);
        $plantuml = new Plantuml($this->getTemplateFileContent($input));

        $output->write(
            $plantuml->export($schema)
        );

        return 0;
    }
}
