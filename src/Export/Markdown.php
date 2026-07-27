<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Export;

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\ColumnInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\NamedIndexAbstract;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\TableInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\SchemaInterface;

class Markdown implements ExportInterface
{
    public function export(SchemaInterface $schema): string
    {
        $blocks = ['# Schema'];

        foreach ($schema->getTables() as $table) {
            $blocks[] = $this->getTable($table);
        }

        $connections = $this->getConnections($schema);
        if ($connections !== '') {
            $blocks[] = $connections;
        }

        return implode("\n\n", $blocks) . "\n";
    }

    private function getTable(TableInterface $table): string
    {
        $sections = [
            sprintf('## `%s` table', $table->getName()),
            $this->getColumns($table),
        ];

        if ($table->getPrimaryKey() !== null) {
            $sections[] = "### Primary Key\n\n" . $this->table(
                ['Columns', 'Parameters'],
                [
                    [
                        implode(', ', $table->getPrimaryKey()->getColumns()),
                        $this->value($table->getPrimaryKey()->getOtherParameters()),
                    ],
                ]
            );
        }

        $indexGroups = [
            'Indexes' => $table->getSimpleIndexes(),
            'Unique Indexes' => $table->getUniqueIndexes(),
            'Fulltext Indexes' => $table->getFulltextIndexes(),
            'Spatial Indexes' => $table->getSpatialIndexes(),
        ];

        foreach ($indexGroups as $title => $indexes) {
            $rows = [];
            foreach ($indexes as $index) {
                $rows[] = [
                    $index instanceof NamedIndexAbstract ? $index->getName() : '',
                    implode(', ', $index->getColumns()),
                    $this->value($index->getOtherParameters()),
                ];
            }

            if ($rows !== []) {
                $sections[] = sprintf("### %s\n\n", $title) . $this->table(
                    ['Name', 'Columns', 'Parameters'],
                    $rows
                );
            }
        }

        return implode("\n\n", $sections);
    }

    private function getColumns(TableInterface $table): string
    {
        $rows = [];
        foreach ($table->getColumns() as $column) {
            $rows[] = [
                $column->getName(),
                $this->getType($column),
                $this->value($column->getOtherParameters()),
                $this->value($column->getComment()),
            ];
        }

        return "### Columns\n\n" . $this->table(
            ['Name', 'Type', 'Parameters', 'Comment'],
            $rows
        );
    }

    private function getType(ColumnInterface $column): string
    {
        if ($column->getTypeParameters() === []) {
            return $column->getType();
        }

        return sprintf(
            '%s ( %s )',
            $column->getType(),
            implode(', ', $column->getTypeParameters())
        );
    }

    private function getConnections(SchemaInterface $schema): string
    {
        $rows = [];
        foreach ($schema->getConnections() as $connection) {
            $rows[] = [
                $connection->getType(),
                $this->getConnectionSide($connection->getChildTableName(), $connection->getChildTableColumns()),
                $this->getConnectionSide($connection->getParentTableName(), $connection->getParentTableColumns()),
            ];
        }

        if ($rows === []) {
            return '';
        }

        return "## Connections\n\n" . $this->table(
            ['Type', 'Child', 'Parent'],
            $rows
        );
    }

    private function getConnectionSide(string $tableName, array $columns): string
    {
        return sprintf('%s ( %s )', $tableName, implode(', ', $columns));
    }

    private function value(string $value): string
    {
        return $value === '' ? '-' : $value;
    }

    private function table(array $headers, array $rows): string
    {
        $lines = [
            '| ' . implode(' | ', $headers) . ' |',
            '| ' . implode(' | ', array_fill(0, count($headers), '---')) . ' |',
        ];

        foreach ($rows as $row) {
            $lines[] = '| ' . implode(' | ', array_map($this->escape(...), $row)) . ' |';
        }

        return implode("\n", $lines);
    }

    private function escape(string $value): string
    {
        return str_replace(['|', "\n"], ['\\|', ' '], $value);
    }
}
