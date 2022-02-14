<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Parser;

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\NotDefinedConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToOneConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKeyInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\TableCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\TableInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\SchemaInterface;

abstract class ParserAbstract implements ParserInterface
{
    abstract protected function parseCreateCondition(string $createTableSchema): ?TableInterface;
    abstract protected function getTableNameFromCreateTableSchema(string $createTableSchema): string;

    public function run(
        string $nativeSqlSchema,
        ConnectionCollectionInterface $forcedConnectionCollection
    ): SchemaInterface {
        $connectionCollection = new ConnectionCollection();

        $connectionCollection
            ->adds(...$forcedConnectionCollection)
            ->adds(...$this->getConnectionsByAlterTable($nativeSqlSchema));

        $nativeSqlSchema = $this->removeLineComments($nativeSqlSchema);
        $nativeSqlSchema = $this->removeMultiLineComments($nativeSqlSchema);
        $nativeSqlSchema = $this->removeFormating($nativeSqlSchema);

        $schema = new Schema();
        foreach ($this->getCreateTableConditions($nativeSqlSchema) as $sql) {
            $table = $this->parseCreateCondition($sql);

            $connectionCollection->adds(
                ...
                $this->getConnectionsByCreateTable($sql)
            );

            if ($table instanceof TableInterface) {
                $schema->addTable($table);
            }
        }

        $parseredConnections = $this->parserConnections(
            $schema->getTables(),
            $connectionCollection
        );

        foreach ($parseredConnections as $connection) {
            $schema->addConnection($connection);
        }

        return $schema;
    }

    public function getConnectionsByAlterTable(string $sqls): ConnectionCollectionInterface
    {
        preg_match_all(
            '/#
            (?<alterTableCondition>
                ALTER\sTABLE\s+
                (`?)
                (?<childTableName>\S+)
                (`?)
                [^;]+
                ;
            )
            #/mx',
            $sqls,
            $alterTableMatches
        );

        $conditions = [];
        if (!empty($alterTableMatches['alterTableCondition'])) {
            foreach ($alterTableMatches['alterTableCondition'] as $index => $condition) {
                $conditions[$alterTableMatches['childTableName'][$index]][] = $condition;
            }
        }

        return $this->generateConnections($conditions);
    }

    private function generateConnections(array $conditions): ConnectionCollectionInterface
    {
        $connectionCollection = new ConnectionCollection();

        foreach ($conditions as $tableName => $subConditions) {
            foreach ($subConditions as $condition) {
                preg_match_all(
                    '#
                    FOREIGN\sKEY\s+
                    \(
                        (`?)
                            (?<childTableColumns>.+)
                        \1
                    \)
                    \s+
                    REFERENCES
                    \s+
                    `?
                        (?<parentTableName>[a-z0-9_-]+)
                    `?
                    \s+
                    \(
                    `?
                        (?<parentTableColumns>.+)
                    `?
                    \)
                #mx',
                    $condition,
                    $matches
                );

                if (!empty($matches['childTableColumns'])
                    && !empty($matches['parentTableName'])
                    && !empty($matches['parentTableColumns'])
                ) {
                    foreach ($matches['parentTableName'] as $index => $parentTableName) {
                        $childTableColumns = explode(
                            ',',
                            $matches['childTableColumns'][$index]
                        );
                        $childTableColumns = array_map(
                            static function ($column): string {
                                return trim(
                                    $column,
                                    '` '
                                );
                            },
                            $childTableColumns
                        );

                        $parentTableColumns = explode(
                            ',',
                            $matches['parentTableColumns'][$index]
                        );
                        $parentTableColumns = array_map(
                            static function ($column): string {
                                return trim(
                                    $column,
                                    '` '
                                );
                            },
                            $parentTableColumns
                        );

                        $connectionCollection->add(
                            new NotDefinedConnection(
                                trim(
                                    $tableName,
                                    '` '
                                ),
                                trim(
                                    $parentTableName,
                                    '` '
                                ),
                                $childTableColumns,
                                $parentTableColumns
                            )
                        );
                    }
                }
            }
        }

        return $connectionCollection;
    }

    protected function removeLineComments($schema): string
    {
        return preg_replace(
            '#--.+$#m',
            '',
            $schema
        );
    }

    protected function removeMultiLineComments($schema): string
    {
        $commentBeginReplaceString = $this->getSafeRandomString($schema);
        $commentEndReplaceString = $this->getSafeRandomString($schema);

        // Replace /* and */ in string
        $schema = $this->replaceCharactersInString(
            $schema,
            [
                '/*' => $commentBeginReplaceString,
                '*/' => $commentEndReplaceString,
            ]
        );

        // Remove multiline coments
        $schema = preg_replace(
            '#(/\*.*\*/)#Us',
            '',
            $schema
        );

        // Repair /* and */ in string
        $schema = $this->replaceCharactersInString(
            $schema,
            [
                $commentBeginReplaceString => '/*',
                $commentEndReplaceString => '*/',
            ]
        );

        return $schema;
    }

    protected function getSafeRandomString(string $schema): string
    {
        do {
            $safeRandomString = (string)rand();
        } while (strpos(
            $schema,
            $safeRandomString
        ) !== false);

        return $safeRandomString;
    }

    protected function replaceCharactersInString(string $schema, array $replacePairs): string
    {
        return preg_replace_callback(
            '#(\'.*\')#Uxsm',
            static function ($matches) use ($replacePairs): string {
                return strtr(
                    $matches[0],
                    $replacePairs
                );
            },
            $schema
        );
    }

    protected function removeFormating($schema): string
    {
        return preg_replace(
            '/^\s+/m',
            '',
            $schema
        );
    }

    protected function getCreateTableConditions(string $schema): array
    {
        $semicolonReplaceString = $this->getSafeRandomString($schema);

        $schema = $this->replaceCharactersInString(
            $schema,
            [';' => $semicolonReplaceString]
        );

        preg_match_all(
            '
            #
            
                (?<createConditions>
                    CREATE\s+TABLE\s+.+\(.*\).*
                    (;|$)
                )
            #xsUi',
            $schema,
            $matches
        );

        $createTables = [];
        foreach ($matches['createConditions'] as $condition) {
            $createTables[] = $this->replaceCharactersInString(
                $condition,
                [$semicolonReplaceString => ';']
            );
        }

        return $createTables;
    }

    public function getConnectionsByCreateTable(string $sql): ConnectionCollectionInterface
    {
        preg_match_all(
            '/#
            (
                CONSTRAINT
                 (?<foreignKeyCondition>.*)$
               
            )
        #/mxsU',
            $sql,
            $createTableMatches
        );

        $conditions = [];
        if (!empty($createTableMatches['foreignKeyCondition'])) {
            foreach ($createTableMatches['foreignKeyCondition'] as $condition) {
                $conditions[$this->getTableNameFromCreateTableSchema($sql)][] = $condition;
            }
        }

        return $this->generateConnections($conditions);
    }

    private function parserConnections(
        TableCollection $tables,
        ConnectionCollectionInterface $connections
    ): ConnectionCollection {
        $connectionCollection = new ConnectionCollection();

        foreach ($tables as $iteratedTable) {
            foreach ($connections as $connection) {
                if ($connection->getChildTableName() === '*'
                    || $connection->getChildTableName() === $iteratedTable->getName()
                ) {
                    $columns = $iteratedTable->getColumns();

                    if (empty(array_diff($connection->getChildTableColumns(), $columns->getColumnsName()))) {
                        $parentTable = $tables->offsetGet($connection->getParentTableName());

                        if ($parentTable instanceof TableInterface
                            && empty(
                                array_diff(
                                    $connection->getParentTableColumns(),
                                    $parentTable->getColumns()->getColumnsName()
                                )
                            )
                            && $connection->getParentTableName() !== $iteratedTable->getName()
                        ) {
                            $childTableColumns = $connection->getChildTableColumns();
                            sort($childTableColumns);

                            $oneToOne = false;

                            foreach ($iteratedTable->getUniqueIndexes() as $uniqueIndex) {
                                if ($uniqueIndex->getColumns() === $childTableColumns) {
                                    $oneToOne = true;
                                }
                            }

                            if ($iteratedTable->getPrimaryKey() instanceof PrimaryKeyInterface
                                && $iteratedTable->getPrimaryKey()->getColumns() === $childTableColumns
                            ) {
                                $oneToOne = true;
                            }

                            if ($oneToOne) {
                                $connectionCollection->add(
                                    new OneToOneConnection(
                                        $iteratedTable->getName(),
                                        $connection->getParentTableName(),
                                        $connection->getChildTableColumns(),
                                        $connection->getParentTableColumns()
                                    )
                                );
                            } else {
                                $connectionCollection->add(
                                    new OneToManyConnection(
                                        $iteratedTable->getName(),
                                        $connection->getParentTableName(),
                                        $connection->getChildTableColumns(),
                                        $connection->getParentTableColumns()
                                    )
                                );
                            }
                        }
                    }
                }
            }
        }

        return $connectionCollection;
    }
}
