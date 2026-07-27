<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database;

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\ColumnCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\ColumnCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\ColumnInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\FulltextIndexCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\FulltextIndexCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\FulltextIndexInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKeyInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SimpleIndexCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SimpleIndexCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SimpleIndexInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SpatialIndexCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SpatialIndexCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SpatialIndexInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\UniqueIndexCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\UniqueIndexCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\UniqueIndexInterface;

final class Table implements TableInterface
{
    public private(set) ColumnCollectionInterface $columns;

    public private(set) ?PrimaryKeyInterface $primaryKey = null;

    public private(set) SimpleIndexCollectionInterface $simpleIndexes;

    public private(set) UniqueIndexCollectionInterface $uniqueIndexes;

    public private(set) FulltextIndexCollectionInterface $fulltextIndexes;

    public private(set) SpatialIndexCollectionInterface $spatialIndexes;

    public function __construct(
        public readonly string $name
    ) {
        $this->columns = new ColumnCollection();
        $this->simpleIndexes = new SimpleIndexCollection();
        $this->uniqueIndexes = new UniqueIndexCollection();
        $this->fulltextIndexes = new FulltextIndexCollection();
        $this->spatialIndexes = new SpatialIndexCollection();
    }

    public function addColumn(ColumnInterface $column): self
    {
        $this->columns->add($column);

        return $this;
    }

    public function addSimpleIndex(SimpleIndexInterface $index): self
    {
        $this->simpleIndexes->add($index);

        return $this;
    }

    public function addUniqueIndex(UniqueIndexInterface $unique): self
    {
        $this->uniqueIndexes->add($unique);

        return $this;
    }

    public function addFullTextIndex(FulltextIndexInterface $fulltextIndex): self
    {
        $this->fulltextIndexes->add($fulltextIndex);

        return $this;
    }

    public function addSpatialIndex(SpatialIndexInterface $spatialIndex): self
    {
        $this->spatialIndexes->add($spatialIndex);

        return $this;
    }

    public function setPrimaryKey(PrimaryKeyInterface $primaryKey): self
    {
        $this->primaryKey = $primaryKey;

        return $this;
    }
}
