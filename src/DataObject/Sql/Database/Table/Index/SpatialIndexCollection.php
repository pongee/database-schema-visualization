<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index;

class SpatialIndexCollection implements SpatialIndexCollectionInterface
{
    private array $spatialIndexes = [];

    public function add(SpatialIndexInterface $spatialIndex): self
    {
        $this->spatialIndexes[] = $spatialIndex;

        return $this;
    }

    public function getIterator(): SpatialIndexIterator
    {
        return new SpatialIndexIterator($this->spatialIndexes);
    }
}
