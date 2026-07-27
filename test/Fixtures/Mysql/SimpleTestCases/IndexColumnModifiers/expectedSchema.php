<?php

declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SimpleIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;

return new Schema()
    ->addTable(
        new Table()
            ->setName('post')
            ->addColumn(
                new Column(
                    'id',
                    'int',
                    ['10'],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'slug',
                    'varchar',
                    ['255'],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'title',
                    'varchar',
                    ['255'],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'views',
                    'int',
                    ['10'],
                    'NOT NULL',
                    ''
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_slug',
                    ['slug']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_slug_title',
                    ['slug', 'title']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_views',
                    ['views']
                )
            )
            ->setPrimaryKey(new PrimaryKey(['id']))
    );
