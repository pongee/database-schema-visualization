<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index;

abstract class NamedIndexAbstract extends IndexAbstract
{
    public function __construct(
        protected string $name,
        protected array $columns,
        protected string $otherParameters = ''
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
