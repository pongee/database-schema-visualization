<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection;

use ArrayIterator;

class ConnectionIterator extends ArrayIterator
{
    public function current(): ?ConnectionInterface
    {
        return parent::current();
    }
}
