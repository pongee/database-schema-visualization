<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database;

use ArrayIterator;

final class TableIterator extends ArrayIterator
{
    public function current(): ?TableInterface
    {
        return parent::current();
    }
}
