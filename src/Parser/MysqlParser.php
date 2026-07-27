<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Parser;

use Override;
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
    /**
     * @return list<string>
     */
    protected function getColumnTypes(): array
    {
        return [
            'TINYINT', 'BOOLEAN', 'BOOL',
            'SMALLINT',
            'MEDIUMINT',
            'MIDDLEINT',
            'BIGINT',
            'INTEGER',
            'INT1', 'INT2', 'INT3', 'INT4', 'INT8',
            'INT',
            'SERIAL',
            'BIT',
            'FLOAT',
            'DOUBLE',
            'REAL',
            'DECIMAL',
            'NUMERIC',
            'FIXED',
            'DEC',
            'VARCHAR',
            'CHAR',
            'TINYTEXT',
            'MEDIUMTEXT',
            'LONGTEXT',
            'TEXT',
            'JSON',
            'VECTOR',
            'VARBINARY',
            'BINARY',
            'TINYBLOB',
            'MEDIUMBLOB',
            'LONGBLOB',
            'BLOB',
            'DATETIME',
            'TIMESTAMP',
            'DATE',
            'TIME',
            'YEAR',
            'GEOMETRYCOLLECTION',
            'GEOMCOLLECTION',
            'MULTILINESTRING',
            'MULTIPOLYGON',
            'MULTIPOINT',
            'LINESTRING',
            'POLYGON',
            'POINT',
            'GEOMETRY',
        ];
    }

    #[Override]
    protected function getCreateTablePattern(): string
    {
        return 'CREATE\s+TABLE';
    }

    protected function parseCreateCondition(string $createTableSchema): TableInterface
    {
        $table = new Table($this->getTableNameFromCreateTableSchema($createTableSchema));

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
        if (!$primaryKey instanceof PrimaryKeyInterface) {
            $primaryKey = $this->getInlinePrimaryKey($table);
        }

        if ($primaryKey instanceof PrimaryKeyInterface) {
            $table->setPrimaryKey($primaryKey);
        }

        return $table;
    }

    protected function getTableNameFromCreateTableSchema(string $createTableSchema): string
    {
        preg_match(
            '/' . $this->getCreateTablePattern() . '\s+(?:IF\s+NOT\s+EXISTS\s+)?`?(?<name>[^`(]+?)`?\s*\(/i',
            $createTableSchema,
            $matches
        );

        return !empty($matches['name']) ? $this->trimName($matches['name']) : '';
    }

    private function trimName(string $string): string
    {
        return trim(
            $string,
            " `'"
        );
    }

    private function getColumnsWithoutRequiredTypeParametersFromCreateTableSchema(
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
            (?<type>' . implode('|', $this->getColumnTypes()) . ')
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
                    $this->stripUnsupportedClauses($this->getFormatedParameter($matches['otherParameters'][$i])),
                    $this->unescapeComment($matches['comment'][$i])
                )
            );
        }

        return $columnCollection;
    }

    private function trimNames(string ...$strings): array
    {
        return array_map(
            $this->trimName(...),
            $strings
        );
    }

    private function getFormatedParameters(string ...$strings): array
    {
        return array_map(
            $this->getFormatedParameter(...),
            $strings
        );
    }

    private function getFormatedParameter(string $string): string
    {
        return preg_replace('/[\r\n]+/m', ' ', trim($string));
    }

    private function stripUnsupportedClauses(string $otherParameters): string
    {
        return trim((string) preg_replace('/\b(?:REFERENCES|GENERATED)\b.*$|\bAS\s*\(.*$/is', '', $otherParameters));
    }

    private function cleanIndexColumns(string $rawColumns): array
    {
        return array_map(
            $this->cleanIndexColumn(...),
            explode(',', $rawColumns)
        );
    }

    private function cleanIndexColumn(string $column): string
    {
        $column = trim($column);
        $column = preg_replace('/\s+(ASC|DESC)$/i', '', $column);
        $column = preg_replace('/^(`?[\w-]+`?)\s*\(\s*\d+\s*\)$/', '$1', (string) $column);

        return $this->trimName($column);
    }

    private function unescapeComment(string $comment): string
    {
        return str_replace(["''", "\\'"], "'", $comment);
    }

    private function splitEnumeratedValues(string $rawParameters): array
    {
        preg_match_all("/'((?:[^']|'')*)'/", $rawParameters, $matches);

        return array_map(
            static fn(string $value): string => str_replace("''", "'", $value),
            $matches[1]
        );
    }

    private function getColumnsWithRequiredTypeParametersFromCreateTableSchema(
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
                    $this->splitEnumeratedValues($matches['typeParameters'][$i]),
                    $this->stripUnsupportedClauses($this->getFormatedParameter($matches['otherParameters'][$i])),
                    $this->unescapeComment($matches['comment'][$i])
                )
            );
        }

        return $columnCollection;
    }

    private function getSimpleIndexesFromCreateTableSchema(string $createTableSchema): SimpleIndexCollectionInterface
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
                (?<columns>(?:[^()]|\([^()]*\))+)
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
                    $this->cleanIndexColumns($matches['columns'][$i])
                )
            );
        }

        return $keyCollection;
    }

    private function getUniqueIndexesFromCreateTableSchema(string $createTableSchema): UniqueIndexCollectionInterface
    {
        preg_match_all(
            '#
            (?!,)
            \s*
            UNIQUE\s*(?:(?:KEY|INDEX)\s+)?+
            `?
            (?<name>\w*)
            `?
            \s*
            \(
                (?<columns>(?:[^()]|\([^()]*\))+)
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
                    $this->cleanIndexColumns($matches['columns'][$i])
                )
            );
        }

        return $keyCollection;
    }

    private function getFulltextIndexesFromCreateTableSchema(
        string $createTableSchema
    ): FulltextIndexCollectionInterface {
        preg_match_all(
            '#
            (?!,)
            \s*
            FULLTEXT\s*(?:(?:KEY|INDEX)\s+)?+
            `?
            (?<name>\w*)
            `?
            \s*
            \(
                (?<columns>(?:[^()]|\([^()]*\))+)
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
                    $this->cleanIndexColumns($matches['columns'][$i])
                )
            );
        }

        return $keyCollection;
    }

    private function getSpatialIndexesFromCreateTableSchema(
        string $createTableSchema
    ): SpatialIndexCollectionInterface {
        preg_match_all(
            '#
            (?!,)
            \s*
            SPATIAL\s*(?:(?:KEY|INDEX)\s+)?+
            `?
            (?<name>\w*)
            `?
            \s*
            \(
                (?<columns>(?:[^()]|\([^()]*\))+)
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
                    $this->cleanIndexColumns($matches['columns'][$i])
                )
            );
        }

        return $keyCollection;
    }

    private function getPrimaryKeyFromCreateTableSchema(string $createTableSchema): ?PrimaryKeyInterface
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
                $this->cleanIndexColumns($match['columns'])
            );
        }

        return null;
    }

    private function getInlinePrimaryKey(TableInterface $table): ?PrimaryKeyInterface
    {
        foreach ($table->columns as $column) {
            if (preg_match('/\bPRIMARY\s+KEY\b/i', $column->otherParameters)) {
                return new PrimaryKey([$column->name]);
            }
        }

        return null;
    }
}
