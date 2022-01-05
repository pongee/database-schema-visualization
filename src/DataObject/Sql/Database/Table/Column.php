<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;

class Column implements ColumnInterface
{
    /** @var string */
    private $name;
    /** @var string */
    private $type;
    /** @var array */
    private $typeParameters;
    /** @var string */
    private $otherParameters;
    /** @var string */
    private $comment;

    public function __construct(
        string $name,
        string $type,
        array $typeParameters,
        string $otherParameters,
        string $comment
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->typeParameters = $typeParameters;
        $this->otherParameters = $otherParameters;
        $this->comment = $comment;
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
