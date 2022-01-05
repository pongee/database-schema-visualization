<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index;

abstract class IndexAbstract implements IndexInterface
{
    /** @var array */
    protected $columns;

    /** @var string */
    protected $otherParameters;

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getOtherParameters(): string
    {
        return $this->otherParameters;
    }
}
