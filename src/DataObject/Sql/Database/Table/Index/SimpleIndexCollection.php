<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index;

class SimpleIndexCollection implements SimpleIndexCollectionInterface
{
    /** @var SimpleIndexInterface[] */
    private array $simpleIndexes = [];

    public function add(SimpleIndexInterface $simpleIndex): self
    {
        $this->simpleIndexes[] = $simpleIndex;

        return $this;
    }

    public function getIterator(): SimpleIndexIterator
    {
        return new SimpleIndexIterator($this->simpleIndexes);
    }
}
