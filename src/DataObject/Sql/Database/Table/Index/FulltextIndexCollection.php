<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index;

class FulltextIndexCollection implements FulltextIndexCollectionInterface
{
    /** @var FulltextIndexInterface[] */
    private array $fulltextIndexes = [];

    public function add(FulltextIndexInterface $fulltextIndexes): self
    {
        $this->fulltextIndexes[] = $fulltextIndexes;

        return $this;
    }

    public function getIterator(): FulltextIndexIterator
    {
        return new FulltextIndexIterator($this->fulltextIndexes);
    }
}
