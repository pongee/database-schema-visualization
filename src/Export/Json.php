<?php declare(strict_types=1);

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

        foreach ($schema->getTables() as $table) {
            $return['tables'][$table->getName()] = [
                'columns' => $this->getColumns($table),
                'indexes' => [
                    'simple' => $this->getSimpleIndexes($table),
                    'spatial' => $this->getSpatialIndexes($table),
                    'fulltext' => $this->getFulltextIndexes($table),
                    'unique' => $this->getUniqueIndexes($table),
                ],
                'primaryKey' => $this->getPrimiaryKey($table),
            ];
        }

        foreach ($schema->getConnections() as $connection) {
            $return['connections'][] = $this->getConnction($connection);
        }

        return json_encode(
            $return,
            JSON_PRETTY_PRINT
        );
    }

    private function getColumns(TableInterface $table): array
    {
        $columns = [];
        foreach ($table->getColumns() as $column) {
            $columns[] = [
                'name' => $column->getName(),
                'type' => $column->getType(),
                'typeParameters' => $column->getTypeParameters(),
                'otherParameters' => $column->getOtherParameters(),
                'comment' => $column->getComment(),
            ];
        }

        return $columns;
    }

    private function getSimpleIndexes(TableInterface $table): array
    {
        $indexes = [];
        foreach ($table->getSimpleIndexes() as $index) {
            $indexes[] = $this->getIndexData($index);
        }

        return $indexes;
    }

    private function getIndexData(IndexInterface $index): array
    {
        $data = [
            'columns' => $index->getColumns(),
            'otherParameters' => $index->getOtherParameters(),
        ];

        if ($index instanceof NamedIndexAbstract) {
            $data['name'] = $index->getName();
        }

        return $data;
    }

    private function getSpatialIndexes(TableInterface $table): array
    {
        $indexes = [];
        foreach ($table->getSpatialIndexes() as $index) {
            $indexes[] = $this->getIndexData($index);
        }

        return $indexes;
    }

    private function getFulltextIndexes(TableInterface $table): array
    {
        $indexes = [];
        foreach ($table->getFulltextIndexes() as $index) {
            $indexes[] = $this->getIndexData($index);
        }

        return $indexes;
    }

    private function getUniqueIndexes(TableInterface $table): array
    {
        $indexes = [];
        foreach ($table->getUniqueIndexes() as $index) {
            $indexes[] = $this->getIndexData($index);
        }

        return $indexes;
    }

    private function getPrimiaryKey(TableInterface $table): array
    {
        if ($table->getPrimaryKey()) {
            return [
                'columns' => $table->getPrimaryKey()->getColumns(),
                'otherParameters' => $table->getPrimaryKey()->getOtherParameters(),
            ];
        }

        return [];
    }

    private function getConnction(ConnectionInterface $connection): array
    {
        return [
            'type' => $connection->getType(),
            'childTableName' => $connection->getChildTableName(),
            'childTableColumns' => $connection->getChildTableColumns(),
            'parentTableName' => $connection->getParentTableName(),
            'parentTableColumns' => $connection->getParentTableColumns(),
        ];
    }
}
