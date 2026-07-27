<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection;

interface ConnectionInterface
{
    public string $childTableName { get; }

    public string $parentTableName { get; }

    public array $childTableColumns { get; }

    public array $parentTableColumns { get; }

    public function __construct(
        string $childTableName,
        string $parentTableName,
        array $childTableColumns,
        array $parentTableColumns
    );

    public function getType(): string;
}
