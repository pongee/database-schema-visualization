<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index;

abstract class NamedIndexAbstract extends IndexAbstract implements NamedIndexInterface
{
    public function __construct(
        public readonly string $name,
        public readonly array $columns,
        public readonly string $otherParameters = ''
    ) {
    }
}
