<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection;

abstract class ConnectionAbstract implements ConnectionInterface
{
    public function __construct(
        protected string $childTableName,
        protected string $parentTableName,
        protected array $childTableColumns,
        protected array $parentTableColumns
    ) {
    }

    public function getChildTableName(): string
    {
        return $this->childTableName;
    }

    public function getParentTableName(): string
    {
        return $this->parentTableName;
    }

    public function getChildTableColumns(): array
    {
        return $this->childTableColumns;
    }

    public function getParentTableColumns(): array
    {
        return $this->parentTableColumns;
    }
}
