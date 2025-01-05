<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection;

use IteratorAggregate;

interface ConnectionCollectionInterface extends IteratorAggregate
{
    public function add(ConnectionInterface $connection);

    public function adds(ConnectionInterface ...$connections);

    public function getIterator(): ConnectionIterator;

    public function jsonSerialize(): array;
}
