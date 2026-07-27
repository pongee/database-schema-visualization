<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index;

interface IndexInterface
{
    public array $columns { get; }

    public string $otherParameters { get; }
}
