<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;

class Column implements ColumnInterface
{
    public function __construct(
        private string $name,
        private string $type,
        private array $typeParameters,
        private string $otherParameters,
        private string $comment
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
