<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Command\Mysql;

use Pongee\DatabaseSchemaVisualization\Export\Json;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MysqlJsonCommand extends MysqlCommandAbstract
{
    protected function configure(): void
    {
        $this
            ->setName('mysql:json')
            ->setDescription('Generate mysql schema dump as JSON.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sqlFileContent = $this->getSqlFileContent($input);

        $output->write(
            (new Json())->export(
                $this->parser->run(
                    $sqlFileContent,
                    $this->getForcedConnections($input->getOption(self::OPTION_CONNECTION))
                )
            )
        );

        return 0;
    }
}
