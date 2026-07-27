<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index;

interface NamedIndexInterface extends IndexInterface
{
    public string $name { get; }

    public function __construct(string $name, array $columns, string $otherParameters = '');
}
