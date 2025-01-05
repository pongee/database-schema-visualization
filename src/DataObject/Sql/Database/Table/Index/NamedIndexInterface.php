<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index;

interface NamedIndexInterface extends IndexInterface
{
    public function __construct(string $name, array $columns, string $otherParameters = '');

    public function getName(): string;
}
