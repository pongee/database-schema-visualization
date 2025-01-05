<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;

class Column implements ColumnInterface
{
    public function __construct(
        private readonly string $name,
        private readonly string $type,
        private readonly array $typeParameters,
        private readonly string $otherParameters,
        private readonly string $comment
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getTypeParameters(): array
    {
        return $this->typeParameters;
    }

    public function getOtherParameters(): string
    {
        return $this->otherParameters;
    }

    public function getComment(): string
    {
        return $this->comment;
    }
}
