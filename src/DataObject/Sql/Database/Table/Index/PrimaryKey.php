<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index;

readonly class PrimaryKey extends IndexAbstract implements PrimaryKeyInterface
{
    public function __construct(
        public array $columns,
        public string $otherParameters = ''
    ) {
    }
}
