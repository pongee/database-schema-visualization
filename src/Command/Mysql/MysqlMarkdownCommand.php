<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Command\Mysql;

use Pongee\DatabaseSchemaVisualization\Export\Markdown;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MysqlMarkdownCommand extends MysqlCommandAbstract
{
    protected function configure(): void
    {
        $this
            ->setName('mysql:markdown')
            ->setDescription('Generate mysql schema dump as Markdown.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sqlFileContent = $this->getSqlFileContent($input);

        $output->write(
            new Markdown()->export(
                $this->parser->run(
                    $sqlFileContent,
                    $this->getForcedConnections($input->getOption(self::OPTION_CONNECTION))
                )
            )
        );

        return 0;
    }
}
