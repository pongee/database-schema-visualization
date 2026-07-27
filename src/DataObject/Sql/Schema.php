<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql;

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\TableCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\TableCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\TableInterface;

final class Schema implements SchemaInterface
{
    public private(set) TableCollectionInterface $tables;

    public private(set) ConnectionCollectionInterface $connections;

    public function __construct()
    {
        $this->tables = new TableCollection();
        $this->connections = new ConnectionCollection();
    }

    public function addTable(TableInterface $table): self
    {
        $this->tables->add($table);

        return $this;
    }

    public function addConnection(ConnectionInterface $connection): self
    {
        $this->connections->add($connection);

        return $this;
    }
}
