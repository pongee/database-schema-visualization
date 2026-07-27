<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index;

class PrimaryKey extends IndexAbstract implements PrimaryKeyInterface
{
    public function __construct(
        public readonly array $columns,
        public readonly string $otherParameters = ''
    ) {
    }
}
