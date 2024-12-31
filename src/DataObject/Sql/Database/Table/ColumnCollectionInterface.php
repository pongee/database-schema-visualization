<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;

use IteratorAggregate;

interface ColumnCollectionInterface extends IteratorAggregate
{
    public function add(ColumnInterface $column);

    public function getColumnsName(): array;

    public function offsetGet(string $columnName): ?ColumnInterface;

    public function getIterator(): ColumnIterator;
}
