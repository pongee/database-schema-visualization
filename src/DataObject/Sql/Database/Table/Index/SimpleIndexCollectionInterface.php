<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index;

use IteratorAggregate;

interface SimpleIndexCollectionInterface extends IteratorAggregate
{
    public function add(SimpleIndexInterface $key);

    public function getIterator(): SimpleIndexIterator;
}
