<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index;

abstract class NamedIndexAbstract extends IndexAbstract
{
    /** @var string */
    protected $name;

    public function __construct(string $name, array $columns, string $otherParameters = '')
    {
        $this->name = $name;
        $this->columns = $columns;
        $this->otherParameters = $otherParameters;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
