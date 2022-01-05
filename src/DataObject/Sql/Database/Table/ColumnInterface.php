<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;

interface ColumnInterface
{
    public function __construct(
        string $name,
        string $type,
        array $typeParameters,
        string $otherParameters,
        string $comment
    );

    public function getName(): string;

    public function getType(): string;

    public function getTypeParameters(): array;

    public function getOtherParameters(): string;

    public function getComment(): string;
}
