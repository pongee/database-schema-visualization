<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql;

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\TableCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\TableCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\TableInterface;

class Schema implements SchemaInterface
{
    protected TableCollectionInterface $tableCollection;

    protected ConnectionCollectionInterface $connectionCollection;

    public function __construct()
    {
        $this->tableCollection = new TableCollection();
        $this->connectionCollection = new ConnectionCollection();
    }

    public function addTable(TableInterface $table): self
    {
        $this->tableCollection->add($table);

        return $this;
    }

    public function getTables(): TableCollectionInterface
    {
        return $this->tableCollection;
    }

    public function addConnection(ConnectionInterface $connection): self
    {
        $this->connectionCollection->add($connection);

        return $this;
    }

    public function getConnections(): ConnectionCollection
    {
        return $this->connectionCollection;
    }
}
