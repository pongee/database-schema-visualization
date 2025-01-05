<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database;

use IteratorAggregate;

interface TableCollectionInterface extends IteratorAggregate
{
    public function add(TableInterface $table);

    public function offsetGet(string $tableName): ?TableInterface;

    public function getIterator(): TableIterator;

    public function jsonSerialize(): array;
}
