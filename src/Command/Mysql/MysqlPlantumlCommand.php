<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Command\Mysql;

use Pongee\DatabaseSchemaVisualization\Export\Plantuml;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MysqlPlantumlCommand extends MysqlCommandAbstract
{
    protected const OPTION_TEMPLATE = 'template';
    protected const DEFAULT_TEMPLATE = 'src/Template/Plantuml/v1.twig';

    protected function configure(): void
    {
        $this
            ->setName('mysql:plantuml')
            ->setDescription('Generate mysql schema dump as Plantuml diagram.')
            ->addOption(
                self::OPTION_TEMPLATE,
                't',
                InputOption::VALUE_OPTIONAL,
                '',
                self::DEFAULT_TEMPLATE
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sqlFileContent = $this->getSqlFileContent($input);
        $templateFileContent = $this->getTemplateFileContent($input);

        $plantuml = new Plantuml($templateFileContent);

        $output->write(
            $plantuml->export(
                $this->parser->run(
                    $sqlFileContent,
                    $this->getForcedConnections($input->getOption(self::OPTION_CONNECTION))
                )
            )
        );

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
}
