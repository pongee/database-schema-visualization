<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index;

use IteratorAggregate;

interface UniqueIndexCollectionInterface extends IteratorAggregate
{
    public function add(UniqueIndexInterface $uniqueIndex);

    public function getIterator(): UniqueIndexIterator;
}
