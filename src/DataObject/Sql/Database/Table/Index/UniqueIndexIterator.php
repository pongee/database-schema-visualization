<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index;

use ArrayIterator;

class UniqueIndexIterator extends ArrayIterator
{
    public function current(): ?UniqueIndex
    {
        return parent::current();
    }
}
