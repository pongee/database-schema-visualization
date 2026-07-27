<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Command;

use Pongee\DatabaseSchemaVisualization\Export\Markdown;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class MarkdownCommand extends CommandAbstract
{
    private const string DEFAULT_TEMPLATE = 'src/Template/Markdown/v1.twig';

    protected function configure(): void
    {
        $this
            ->setDescription('Generate the schema dump as Markdown.')
            ->addTemplateOption(self::DEFAULT_TEMPLATE);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $schema = $this->parseSchema($input);
        $markdown = new Markdown($this->getTemplateFileContent($input));

        $output->write(
            $markdown->export($schema)
        );

        return 0;
    }
}
