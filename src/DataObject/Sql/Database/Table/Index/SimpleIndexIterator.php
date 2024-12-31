<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index;

use ArrayIterator;

class SimpleIndexIterator extends ArrayIterator
{
    public function current(): ?SimpleIndex
    {
        return parent::current();
    }
}
