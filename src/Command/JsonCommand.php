<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Command;

use Pongee\DatabaseSchemaVisualization\Export\Json;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class JsonCommand extends CommandAbstract
{
    protected function configure(): void
    {
        $this->setDescription('Generate the schema dump as JSON.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->write(
            new Json()->export($this->parseSchema($input))
        );

        return 0;
    }
}
