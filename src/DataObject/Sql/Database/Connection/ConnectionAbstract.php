<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection;

abstract class ConnectionAbstract implements ConnectionInterface
{
    /** @var string */
    protected $childTableName;

    /** @var string */
    protected $parentTableName;

    /** @var array */
    protected $childTableColumns;

    /** @var array */
    protected $parentTableColumns;

    public function __construct(
        string $childTableName,
        string $parentTableName,
        array $childTableColumns,
        array $parentTableColumns
    ) {
        $this->childTableName = $childTableName;
        $this->parentTableName = $parentTableName;
        $this->childTableColumns = $childTableColumns;
        $this->parentTableColumns = $parentTableColumns;
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
