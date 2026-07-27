<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;

interface ColumnInterface
{
    public string $name { get; }

    public string $type { get; }

    public array $typeParameters { get; }

    public string $otherParameters { get; }

    public string $comment { get; }

    public function __construct(
        string $name,
        string $type,
        array $typeParameters,
        string $otherParameters,
        string $comment
    );
}
