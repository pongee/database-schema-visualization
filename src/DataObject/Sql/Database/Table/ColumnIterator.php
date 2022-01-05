<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;

use ArrayIterator;

class ColumnIterator extends ArrayIterator
{
    public function current(): ?ColumnInterface
    {
        return parent::current();
    }
}
