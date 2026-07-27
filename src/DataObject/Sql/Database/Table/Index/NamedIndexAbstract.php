<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index;

abstract readonly class NamedIndexAbstract extends IndexAbstract implements NamedIndexInterface
{
    public function __construct(
        public string $name,
        public array $columns,
        public string $otherParameters = ''
    ) {
    }
}
