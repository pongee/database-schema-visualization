<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index;

use ArrayIterator;

class FulltextIndexIterator extends ArrayIterator
{
    public function current(): ?FulltextIndex
    {
        return parent::current();
    }
}
