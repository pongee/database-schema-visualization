<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Parser;

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
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\TableInterface;

class MysqlParser extends ParserAbstract
{
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
        preg_match(
            '/CREATE\s+TABLE.*\s*`?(?<name>(\w|[-])+)`?\s*\(/Uis',
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

                VARCHAR|
                CHAR|
                TINYTEXT|
                MEDIUMTEXT|
                LONGTEXT|
                TEXT|

                JSON|

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
            function ($string) {
                return $this->trimName($string);
            },
            $strings
        );
    }

    protected function getFormatedParameters(string ...$strings): array
    {
        return array_map(
            function ($string) {
                return $this->getFormatedParameter($string);
            },
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
               SET
            )
            (?U:
                \s*
                \(
                    (?<typeParameters>.+)
                \)
            )
            (?U:\s+(?<otherParameters>.*))?
            (?:
                COMMENT\s+
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
            $columnCollection->add(
                new Column(
                    $columName,
                    $matches['type'][$i],
                    $this->trimNames(
                        ...
                        explode(
                            ',',
                            $matches['typeParameters'][$i]
                        )
                    ),
                    $this->getFormatedParameter($matches['otherParameters'][$i]),
                    $matches['comment'][$i]
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
                    explode(
                        ',',
                        $match['columns']
                    )
                )
            );
        }

        return null;
    }
}
