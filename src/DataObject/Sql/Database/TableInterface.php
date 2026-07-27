<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database;

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\ColumnCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\ColumnInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\FulltextIndexCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\FulltextIndexInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKeyInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SimpleIndexCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SimpleIndexInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SpatialIndexCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SpatialIndexInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\UniqueIndexCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\UniqueIndexInterface;

interface TableInterface
{
    public string $name { get; }

    public ColumnCollectionInterface $columns { get; }

    public ?PrimaryKeyInterface $primaryKey { get; }

    public SimpleIndexCollectionInterface $simpleIndexes { get; }

    public UniqueIndexCollectionInterface $uniqueIndexes { get; }

    public FulltextIndexCollectionInterface $fulltextIndexes { get; }

    public SpatialIndexCollectionInterface $spatialIndexes { get; }

    public function __construct(string $name);

    public function setPrimaryKey(PrimaryKeyInterface $primaryKey);

    public function addColumn(ColumnInterface $column);

    public function addSimpleIndex(SimpleIndexInterface $index);

    public function addUniqueIndex(UniqueIndexInterface $unique);

    public function addFullTextIndex(FulltextIndexInterface $fulltextIndex);

    public function addSpatialIndex(SpatialIndexInterface $spatialIndex);
}
