<?php

declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\FulltextIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;

return new Schema()
    ->addTable(
        new Table('products')
            ->addColumn(
                new Column(
                    'id',
                    'INT',
                    [],
                    'PRIMARY KEY',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'name',
                    'VARCHAR',
                    [255],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'category',
                    'VARCHAR',
                    [100],
                    '',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'price',
                    'DECIMAL',
                    [10, 2],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'description',
                    'TEXT',
                    [],
                    '',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['id']))
            ->addFullTextIndex(
                new FulltextIndex(
                    '',
                    ['description']
                )
            )
    );
