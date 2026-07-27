<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Command;

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\NotDefinedConnection;
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

    protected const string OPTION_CONNECTION = 'connection';

    protected const string OPTION_TEMPLATE = 'template';

    protected string $rootDir;

    public function __construct(protected ParserInterface $parser, string $rootDir, string $name)
    {
        parent::__construct($name);
        $this->rootDir = rtrim($rootDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        $this
            ->setHelpDescription()
            ->addFileArgument()
            ->addConnectionOption();
    }

    protected function addConnectionOption(): self
    {
        $this->addOption(
            self::OPTION_CONNECTION,
            'c',
            InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
            "Force foreign keys definitions, if there are no foreign keys defined in sql schema.
            Format: <info>child_table_name.child_table_columns=>parent_table_name.parent_table_columns</info>
            --------
            Example #1:
            <info>foo.bar_id=>bar.id</info><comment>
            It defines a foreign key definition between foo table's bar_id field and bar table's id field.
            ALTER TABLE `foo` ADD FOREIGN KEY (`bar_id`) REFERENCES `bar` (`id`)
            </comment>
            --------
            Example #2:
            <info>foo.bar_id,type=>bar.id,type</info><comment>
            It defines a foreign key definition between foo table's bar_id and type fields,
            and bar table's id and type fields.
            ALTER TABLE `foo` ADD FOREIGN KEY (`bar_id`, `type`) REFERENCES `bar` (`id`, `type`)</comment>
            --------
            Example #3:
            <info>*.bar_id=>bar.id</info><comment>
            It defines a foreign key definition between any table's bar_id field and bar table's id field.</comment>
            "
        );

        return $this;
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
            't',
            InputOption::VALUE_OPTIONAL,
            '',
            $default
        );

        return $this;
    }

    protected function setHelpDescription(): self
    {
        $this->setHelp(
            sprintf(
                "If the tables contain foreign keys it automatically resolves table connections.\n"
                . "Otherwise the relations need to be defined under --%s parameter.\n"
                . "The table connection types (one-to-one, one-to-many) are automatically resolved.\n"
                . "For connection type resolving conditions please see REAMDME.",
                self::OPTION_CONNECTION
            )
        );

        return $this;
    }

    protected function getForcedConnections(array $connections): ConnectionCollection
    {
        $forcedConnectionCollection = new ConnectionCollection();
        foreach ($connections as $connection) {
            preg_match('#
                ^
                (?<childTableName>\S+)
                \.
                (?<childTableColumns>[^=]+)
                =>
                (?<parentTableName>[^.]+)
                \.
                (?<parentTableColumns>[^.]+)
                $
            #x', (string) $connection, $matches);

            if (
                !empty($matches['childTableName'])
                && !empty($matches['childTableColumns'])
                && !empty($matches['parentTableName'])
                && !empty($matches['parentTableColumns'])
            ) {
                $forcedConnectionCollection->add(
                    new NotDefinedConnection(
                        $matches['childTableName'],
                        $matches['parentTableName'],
                        explode(',', $matches['childTableColumns']),
                        explode(',', $matches['parentTableColumns'])
                    )
                );
            }
        }

        return $forcedConnectionCollection;
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
            $this->getForcedConnections($input->getOption(self::OPTION_CONNECTION))
        );
    }
}
