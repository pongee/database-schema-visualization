<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql;

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\TableCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\TableInterface;

interface SchemaInterface
{
    public TableCollectionInterface $tables { get; }

    public ConnectionCollectionInterface $connections { get; }

    public function addTable(TableInterface $table);

    public function addConnection(ConnectionInterface $connection);
}
