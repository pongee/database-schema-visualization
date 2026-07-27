<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Export;

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\IndexInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\NamedIndexAbstract;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\TableInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\SchemaInterface;

class Json implements ExportInterface
{
    public function export(SchemaInterface $schema): string
    {
        $return = [
            'tables' => [],
            'connections' => [],
        ];

        foreach ($schema->tables as $table) {
            $return['tables'][$table->name] = [
                'columns' => $this->getColumns($table),
                'indexes' => [
                    'simple' => $this->getSimpleIndexes($table),
                    'spatial' => $this->getSpatialIndexes($table),
                    'fulltext' => $this->getFulltextIndexes($table),
                    'unique' => $this->getUniqueIndexes($table),
                ],
                'primaryKey' => $this->getPrimaryKey($table),
            ];
        }

        foreach ($schema->connections as $connection) {
            $return['connections'][] = $this->getConnection($connection);
        }

        return json_encode(
            $return,
            JSON_PRETTY_PRINT
        );
    }

    private function getColumns(TableInterface $table): array
    {
        $columns = [];
        foreach ($table->columns as $column) {
            $columns[] = [
                'name' => $column->name,
                'type' => $column->type,
                'typeParameters' => $column->typeParameters,
                'otherParameters' => $column->otherParameters,
                'comment' => $column->comment,
            ];
        }

        return $columns;
    }

    private function getSimpleIndexes(TableInterface $table): array
    {
        $indexes = [];
        foreach ($table->simpleIndexes as $index) {
            $indexes[] = $this->getIndexData($index);
        }

        return $indexes;
    }

    private function getIndexData(IndexInterface $index): array
    {
        $data = [
            'columns' => $index->columns,
            'otherParameters' => $index->otherParameters,
        ];

        if ($index instanceof NamedIndexAbstract) {
            $data['name'] = $index->name;
        }

        return $data;
    }

    private function getSpatialIndexes(TableInterface $table): array
    {
        $indexes = [];
        foreach ($table->spatialIndexes as $index) {
            $indexes[] = $this->getIndexData($index);
        }

        return $indexes;
    }

    private function getFulltextIndexes(TableInterface $table): array
    {
        $indexes = [];
        foreach ($table->fulltextIndexes as $index) {
            $indexes[] = $this->getIndexData($index);
        }

        return $indexes;
    }

    private function getUniqueIndexes(TableInterface $table): array
    {
        $indexes = [];
        foreach ($table->uniqueIndexes as $index) {
            $indexes[] = $this->getIndexData($index);
        }

        return $indexes;
    }

    private function getPrimaryKey(TableInterface $table): array
    {
        if ($table->primaryKey) {
            return [
                'columns' => $table->primaryKey->columns,
                'otherParameters' => $table->primaryKey->otherParameters,
            ];
        }

        return [];
    }

    private function getConnection(ConnectionInterface $connection): array
    {
        return [
            'type' => $connection->getType(),
            'childTableName' => $connection->childTableName,
            'childTableColumns' => $connection->childTableColumns,
            'parentTableName' => $connection->parentTableName,
            'parentTableColumns' => $connection->parentTableColumns,
        ];
    }
}
