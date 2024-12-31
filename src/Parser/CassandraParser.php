<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Parser;

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\FulltextIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\FulltextIndexCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\FulltextIndexCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKeyInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SimpleIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SimpleIndexCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SimpleIndexCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SpatialIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SpatialIndexCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SpatialIndexCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\UniqueIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\UniqueIndexCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\UniqueIndexCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\TableCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\TableInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\SchemaInterface;

/**
 * Class that knows how to parse CQL
 * At the moment its almost a copy of the MysqlParser, with some small changes
 *
 * Note:
 * This class is not complete as i am no CQL expert
 */
class CassandraParser extends ParserAbstract
{
    public function run(
        string $nativeSqlSchema,
        ConnectionCollectionInterface $forcedConnectionCollection
    ): SchemaInterface {
        $runResult = parent::run($nativeSqlSchema, $forcedConnectionCollection);
        $this->handleMapAndSetConnections($runResult->getTables(), $runResult->getConnections());
        return $runResult;
    }


    protected function parseCreateCondition(string $createTableSchema): ?TableInterface
    {
        $table = new Table();
        $table->setName($this->getTableNameFromCreateTableSchema($createTableSchema));

        foreach ($this->getColumnsWithoutRequiredTypeParametersFromCreateTableSchema($createTableSchema) as $column) {
            $table->addColumn($column);
        }

        foreach ($this->getColumnsWithRequiredTypeParametersFromCreateTableSchema($createTableSchema) as $column) {
            $table->addColumn($column);
        }

        foreach ($this->getSimpleIndexesFromCreateTableSchema($createTableSchema) as $index) {
            $table->addSimpleIndex($index);
        }

        foreach ($this->getUniqueIndexesFromCreateTableSchema($createTableSchema) as $index) {
            $table->addUniqueIndex($index);
        }

        foreach ($this->getFulltextIndexesFromCreateTableSchema($createTableSchema) as $index) {
            $table->addFullTextIndex($index);
        }

        foreach ($this->getSpatialIndexesFromCreateTableSchema($createTableSchema) as $index) {
            $table->addSpatialIndex($index);
        }

        $primaryKey = $this->getPrimaryKeyFromCreateTableSchema($createTableSchema);
        if ($primaryKey instanceof PrimaryKeyInterface) {
            $table->setPrimaryKey($primaryKey);
        }

        return $table;
    }

    protected function getTableNameFromCreateTableSchema(string $createTableSchema): string
    {
        // CQL: TYPE can be treated as a table. And we need to show/store TYPEs so we can reference them
        preg_match(
            '/CREATE\s+(TABLE|TYPE).*\s*`?(?<name>(\w|[-])+)`?\s*\(/Uis',
            $createTableSchema,
            $matches
        );

        return !empty($matches['name']) ? $this->trimName($matches['name']) : '';
    }

    protected function trimName(string $string): string
    {
        return trim(
            $string,
            " `'"
        );
    }

    protected function getColumnsWithoutRequiredTypeParametersFromCreateTableSchema(
        string $createTableSchema
    ): Table\ColumnCollectionInterface {
        preg_match_all(
            '#
            (?!,)
            \s*
            `?
            (?<name>\w+)
            `?
            \s+
            (?<type>
                TINYINT|BOOLEAN|BOOL|
                SMALLINT|
                MEDIUMINT|
                INT|INTEGER|
                BIGINT|
                BIT|
                FLOAT|
                DOUBLE|
                DECIMAL|
                COUNTER|

                VARCHAR|
                CHAR|
                TINYTEXT|
                MEDIUMTEXT|
                LONGTEXT|
                TEXT|

                JSON|
                UUID|

                VARBINARY|
                BINARY|
                TINYBLOB|
                MEDIUMBLOB|
                LONGBLOB|
                BLOB|

                DATETIME|
                TIMESTAMP|
                DATE|
                TIME|
                YEAR|

                MULTIPOINT|
                POINT|
                LINESTRING|
                POLYGON|
                GEOMETRY|
                MULTILINESTRING|
                MULTIPOLYGON|
                GEMETRYCOLLECTION
            )
            (?U:
                \s*
                \(
                    (?<typeParameters>.+)
                \)
            )?
            (?U:\s+(?<otherParameters>.*))?
            (?:
                COMMENT\s+
                \'
                    (?U:(?<comment>.+))
                \'
            )?
            \s*
            (?U:(?=(,|\))))
        #xmis',
            $createTableSchema,
            $matches
        );

        $columnCollection = new Table\ColumnCollection();
        foreach ($matches['name'] as $i => $columName) {
            $typeParameters = [];

            if (!empty($matches['typeParameters'][$i])) {
                $typeParameters = $this->trimNames(
                    ...
                    explode(
                        ',',
                        $matches['typeParameters'][$i]
                    )
                );
            }
            // MAP Cassandra special types
            if (0 === stripos($matches['type'][$i], 'uuid')) {
                $matches['type'][$i] = 'VARCHAR';
                $typeParameters[] = '32';
                $matches['comment'][$i] .= ' CQL: UUID';
            }
            if (0 === stripos($matches['type'][$i], 'counter')) {
                $matches['type'][$i] = 'BIGINT';
                $matches['comment'][$i] .= ' CQL: counter';
            }

            $columnCollection->add(
                new Column(
                    $columName,
                    $matches['type'][$i],
                    $this->getFormatedParameters(...$typeParameters),
                    $this->getFormatedParameter($matches['otherParameters'][$i]),
                    $matches['comment'][$i]
                )
            );
        }

        return $columnCollection;
    }

    protected function trimNames(string ...$strings): array
    {
        return array_map(
            fn($string): string => $this->trimName($string),
            $strings
        );
    }

    protected function getFormatedParameters(string ...$strings): array
    {
        return array_map(
            fn($string): string => $this->getFormatedParameter($string),
            $strings
        );
    }

    protected function getFormatedParameter(string $string): string
    {
        return preg_replace('/[\r\n]+/m', ' ', trim($string));
    }

    protected function getColumnsWithRequiredTypeParametersFromCreateTableSchema(
        string $createTableSchema
    ): Table\ColumnCollectionInterface {
        preg_match_all(
            '#
            (?!,)
            \s*
            `?
            (?<name>\w+)
            `?
            \s+
            (?<type>
               ENUM|
               SET|
               MAP|
               FROZEN
            )
            (?U:
                \s*
                \<
                    (?<typeParameters>.+)
                \>
            )
            (?U:\s+(?<otherParameters>.*))?
            (?:
                \/\/\s+
                \'
                    (?U:(?<comment>.+))
                \'
            )?
            \s*
            (?U:(?=(,|\))))
        #Uxmis',
            $createTableSchema,
            $matches
        );

        $columnCollection = new Table\ColumnCollection();


        foreach ($matches['name'] as $i => $columName) {
            $columnType = $matches['type'][$i];
            if (in_array($columnType, ['map', 'set', 'frozen'])) {
                $wasFrozen = false !== stripos($matches['typeParameters'][$i], 'frozen');
                $matches['typeParameters'][$i] = str_replace(
                    ['frozen<', 'frozen <', '>'],
                    '',
                    $matches['typeParameters'][$i]
                );
                if ($wasFrozen) {
                    // remove frozen definition, but make it a comment
                    $matches['comment'][$i] = ' CQL: frozen';
                }
            }

            $columnCollection->add(
                new Column(
                    $columName,
                    $columnType,
                    $this->trimNames(
                        ...
                        explode(
                            ',',
                            $matches['typeParameters'][$i]
                        )
                    ),
                    $this->getFormatedParameter($matches['otherParameters'][$i]),
                    trim($matches['comment'][$i])
                )
            );
        }

        return $columnCollection;
    }

    protected function getSimpleIndexesFromCreateTableSchema(string $createTableSchema): SimpleIndexCollectionInterface
    {
        preg_match_all(
            '#
            (,)
            \s*
            (KEY|INDEX)\s+
            `?
            (?<name>\w*)
            `?
            \s*
            \(
                (?<columns>[^)]+)
            \)
            \s*
            (?<otherParameters>[^,]+)?
            \s*
            (?=(,|\)))
            #Umxi',
            $createTableSchema,
            $matches
        );

        $keyCollection = new SimpleIndexCollection();
        foreach ($matches['name'] as $i => $columName) {
            $keyCollection->add(
                new SimpleIndex(
                    $columName,
                    $this->trimNames(
                        ...
                        explode(
                            ',',
                            $matches['columns'][$i]
                        )
                    )
                )
            );
        }

        return $keyCollection;
    }

    protected function getUniqueIndexesFromCreateTableSchema(string $createTableSchema): UniqueIndexCollectionInterface
    {
        preg_match_all(
            '#
            (?!,)
            \s*
            UNIQUE\s(KEY|INDEX)\s+
            `?
            (?<name>\w*)
            `?
            \s*
            \(
                (?<columns>[^)]+)
            \)
            \s*
            (?<otherParameters>[^,]+)?
            \s*
            (?=(,|\)))
            #Umxi',
            $createTableSchema,
            $matches
        );

        $keyCollection = new UniqueIndexCollection();

        foreach ($matches['name'] as $i => $columName) {
            $keyCollection->add(
                new UniqueIndex(
                    $columName,
                    $this->trimNames(
                        ...
                        explode(
                            ',',
                            $matches['columns'][$i]
                        )
                    )
                )
            );
        }

        return $keyCollection;
    }

    protected function getFulltextIndexesFromCreateTableSchema(
        string $createTableSchema
    ): FulltextIndexCollectionInterface {
        preg_match_all(
            '#
            (?!,)
            \s*
            FULLTEXT\s(KEY|INDEX)\s+
            `?
            (?<name>\w*)
            `?
            \s*
            \(
                (?<columns>[^)]+)
            \)
            \s*
            (?<otherParameters>[^,]+)?
            \s*
            (?=(,|\)))
            #Umxi',
            $createTableSchema,
            $matches
        );

        $keyCollection = new FulltextIndexCollection();
        foreach ($matches['name'] as $i => $columName) {
            $keyCollection->add(
                new FulltextIndex(
                    $columName,
                    $this->trimNames(
                        ...
                        explode(
                            ',',
                            $matches['columns'][$i]
                        )
                    )
                )
            );
        }

        return $keyCollection;
    }

    protected function getSpatialIndexesFromCreateTableSchema(
        string $createTableSchema
    ): SpatialIndexCollectionInterface {
        preg_match_all(
            '#
            (?!,)
            \s*
            SPATIAL\s(KEY|INDEX)\s+
            `?
            (?<name>\w*)
            `?
            \s*
            \(
                (?<columns>[^)]+)
            \)
            \s*
            (?<otherParameters>[^,]+)?
            \s*
            (?=(,|\)))
            #Umxi',
            $createTableSchema,
            $matches
        );

        $keyCollection = new SpatialIndexCollection();
        foreach ($matches['name'] as $i => $columName) {
            $keyCollection->add(
                new SpatialIndex(
                    $columName,
                    $this->trimNames(
                        ...
                        explode(
                            ',',
                            $matches['columns'][$i]
                        )
                    )
                )
            );
        }

        return $keyCollection;
    }

    protected function getPrimaryKeyFromCreateTableSchema(string $createTableSchema): ?PrimaryKeyInterface
    {
        preg_match(
            '#
            (^|,)
            \s*
            PRIMARY\sKEY\s*
            \(
                (?<columns>.+)
            \)
            \s*
            (,|$|\))
            #Umxi',
            $createTableSchema,
            $match
        );

        if (!empty($match['columns'])) {
            return new PrimaryKey(
                $this->trimNames(
                    ...
                    explode(',', $match['columns'])
                )
            );
        }

        return null;
    }

    protected function getCreateTableConditions(string $schema): array
    {
        // treat types as tables so we can reference and show them
        $schema = str_replace('CREATE TYPE', 'CREATE TABLE', $schema);

        return parent::getCreateTableConditions($schema);
    }

    public function getConnectionsByCreateTable(string $sql): ConnectionCollectionInterface
    {
        // nothing to do here, this is done later as we need to know which tables/types actually exist
        return new ConnectionCollection();
    }

    private function handleMapAndSetConnections(
        TableCollection $tables,
        ConnectionCollectionInterface $connections
    ): ConnectionCollection {
        $allDefinedTables = array_map(
            fn(TableInterface $table): string => $table->getName(),
            $tables->getIterator()->getArrayCopy()
        );

        foreach ($tables as $table) {
            foreach ($table->getColumns() as $column) {
                if (!in_array($column->getType(), ['set', 'map', 'frozen'])) {
                    continue;
                }

                foreach ($column->getTypeParameters() as $typeParameter) {
                    if (!isset($allDefinedTables[$typeParameter])) {
                        continue;
                    }
                    $connections->add(new OneToManyConnection($table->getName(), $typeParameter, [], []));
                }
            }
        }

        return $connections;
    }
}
