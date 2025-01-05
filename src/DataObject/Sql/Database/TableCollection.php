<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database;

class TableCollection implements TableCollectionInterface
{
    /** @var TableInterface[] */
    private array $tables = [];

    public function add(TableInterface $table): self
    {
        $this->tables[$table->getName()] = $table;

        return $this;
    }

    public function offsetGet(string $tableName): ?TableInterface
    {
        return $this->tables[$tableName] ?? null;
    }

    public function getIterator(): TableIterator
    {
        return new TableIterator($this->tables);
    }

    public function jsonSerialize(): array
    {
        return $this->tables;
    }
}
