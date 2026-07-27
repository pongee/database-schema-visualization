<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection;

abstract readonly class ConnectionAbstract implements ConnectionInterface
{
    public function __construct(
        public string $childTableName,
        public string $parentTableName,
        public array $childTableColumns,
        public array $parentTableColumns
    ) {
    }
}
