<?php declare(strict_types=1);

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

class Table implements TableInterface
{
    /** @var string */
    private $name = '';

    /** @var ColumnCollectionInterface */
    private $columns;

    /** @var PrimaryKeyInterface */
    private $primaryKey;

    /** @var SimpleIndexCollectionInterface */
    private $simpleIndexes;

    /** @var UniqueIndexCollectionInterface */
    private $uniqueIndexes;

    /** @var FulltextIndexCollectionInterface */
    private $fulltextIndexes;

    /** @var SpatialIndexCollectionInterface */
    private $spatialIndexes;

    public function __construct()
    {
        $this->columns = new ColumnCollection();
        $this->simpleIndexes = new SimpleIndexCollection();
        $this->uniqueIndexes = new UniqueIndexCollection();
        $this->fulltextIndexes = new FulltextIndexCollection();
        $this->spatialIndexes = new SpatialIndexCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getColumns(): ColumnCollectionInterface
    {
        return $this->columns;
    }

    public function getPrimaryKey(): ?PrimaryKeyInterface
    {
        return $this->primaryKey;
    }

    public function setPrimaryKey(PrimaryKeyInterface $primaryKey): self
    {
        $this->primaryKey = $primaryKey;

        return $this;
    }

    public function getSimpleIndexes(): SimpleIndexCollectionInterface
    {
        return $this->simpleIndexes;
    }

    public function getUniqueIndexes(): UniqueIndexCollectionInterface
    {
        return $this->uniqueIndexes;
    }

    public function getFulltextIndexes(): FulltextIndexCollectionInterface
    {
        return $this->fulltextIndexes;
    }

    public function getSpatialIndexes(): SpatialIndexCollectionInterface
    {
        return $this->spatialIndexes;
    }
}
