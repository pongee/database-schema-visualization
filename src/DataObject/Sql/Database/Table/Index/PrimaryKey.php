<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index;

class PrimaryKey extends IndexAbstract implements PrimaryKeyInterface
{
    public function __construct(
        protected array $columns,
        protected string $otherParameters = ''
    ) {
    }
}
