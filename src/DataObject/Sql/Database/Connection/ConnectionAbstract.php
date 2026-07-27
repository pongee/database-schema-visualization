<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection;

abstract class ConnectionAbstract implements ConnectionInterface
{
    public function __construct(
        public readonly string $childTableName,
        public readonly string $parentTableName,
        public readonly array $childTableColumns,
        public readonly array $parentTableColumns
    ) {
    }
}
