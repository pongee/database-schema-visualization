<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index;

use IteratorAggregate;

interface FulltextIndexCollectionInterface extends IteratorAggregate
{
    public function add(FulltextIndexInterface $key);

    public function getIterator(): FulltextIndexIterator;
}
