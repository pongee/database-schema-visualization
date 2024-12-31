<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index;

class UniqueIndexCollection implements UniqueIndexCollectionInterface
{
    private array $uniqueIndexes = [];

    public function add(UniqueIndexInterface $uniqueIndex): self
    {
        $this->uniqueIndexes[] = $uniqueIndex;

        return $this;
    }

    public function getIterator(): UniqueIndexIterator
    {
        return new UniqueIndexIterator($this->uniqueIndexes);
    }
}
