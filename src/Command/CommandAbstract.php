<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Command;

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\SchemaInterface;
use Pongee\DatabaseSchemaVisualization\Parser\ParserInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

abstract class CommandAbstract extends Command
{
    protected const string ARGUMENT_FILE = 'file';

    protected const string OPTION_TEMPLATE = 'template';

    protected string $rootDir;

    public function __construct(protected ParserInterface $parser, string $rootDir, string $name)
    {
        parent::__construct($name);
        $this->rootDir = rtrim($rootDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        $this
            ->setHelpDescription()
            ->addFileArgument();
    }

    protected function addFileArgument(): self
    {
        $this->addArgument(
            self::ARGUMENT_FILE,
            InputArgument::REQUIRED,
            'The sql schema file.'
        );

        return $this;
    }

    protected function addTemplateOption(string $default): self
    {
        $this->addOption(
            self::OPTION_TEMPLATE,
            null,
            InputOption::VALUE_OPTIONAL,
            '',
            $default
        );

        return $this;
    }

    protected function setHelpDescription(): self
    {
        $this->setHelp(
            "If the tables contain foreign keys it automatically resolves table connections.\n"
            . "The table connection types (one-to-one, one-to-many) are automatically resolved.\n"
            . "For connection type resolving conditions please see README."
        );

        return $this;
    }

    protected function getSqlFileContent(InputInterface $input): string
    {
        $sqlFilePath = $this->rootDir . $input->getArgument(self::ARGUMENT_FILE);

        if (!is_file($sqlFilePath)) {
            throw new RuntimeException(sprintf('Bad sql file path. [%s] is not a file.', $sqlFilePath));
        }

        if (!is_readable($sqlFilePath)) {
            throw new RuntimeException(sprintf('Bad sql file path. [%s] is unreadable.', $sqlFilePath));
        }

        return file_get_contents($sqlFilePath);
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

    protected function parseSchema(InputInterface $input): SchemaInterface
    {
        return $this->parser->run(
            $this->getSqlFileContent($input),
            new ConnectionCollection()
        );
    }
}
