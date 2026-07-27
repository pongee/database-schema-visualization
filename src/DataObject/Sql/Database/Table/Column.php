<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;

final readonly class Column implements ColumnInterface
{
    public function __construct(
        public string $name,
        public string $type,
        public array $typeParameters,
        public string $otherParameters,
        public string $comment
    ) {
    }
}
