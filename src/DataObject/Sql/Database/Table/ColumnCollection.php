<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;

final class ColumnCollection implements ColumnCollectionInterface
{
    /** @var ColumnInterface[] */
    private array $columns = [];

    public function add(ColumnInterface $column): void
    {
        $this->columns[$column->name] = $column;
    }

    public function getColumnsName(): array
    {
        return array_keys($this->columns);
    }

    public function offsetGet(string $columnName): ?ColumnInterface
    {
        return $this->columns[$columnName] ?? null;
    }

    public function getIterator(): ColumnIterator
    {
        return new ColumnIterator($this->columns);
    }
}
