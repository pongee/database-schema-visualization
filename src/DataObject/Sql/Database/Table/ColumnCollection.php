<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;

class ColumnCollection implements ColumnCollectionInterface
{
    /** @var ColumnInterface[] */
    private $columns = [];

    public function add(ColumnInterface $column)
    {
        $this->columns[$column->getName()] = $column;
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
