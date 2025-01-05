<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql;

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\TableCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\TableInterface;

interface SchemaInterface
{
    public function addTable(TableInterface $table);

    public function getTables(): TableCollectionInterface;

    public function addConnection(ConnectionInterface $connection);

    public function getConnections(): ConnectionCollection;
}
