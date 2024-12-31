<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index;

use ArrayIterator;

class SpatialIndexIterator extends ArrayIterator
{
    public function current(): ?SpatialIndex
    {
        return parent::current();
    }
}
