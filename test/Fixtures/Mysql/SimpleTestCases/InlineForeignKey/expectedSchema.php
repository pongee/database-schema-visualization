<?php

declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;

return new Schema()
    ->addTable(
        new Table('user')
            ->addColumn(
                new Column(
                    'id',
                    'int',
                    ['10'],
                    'NOT NULL',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['id']))
    )
    ->addTable(
        new Table('post')
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
                    'author_id',
                    'int',
                    ['10'],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'editor_id',
                    'int',
                    ['10'],
                    'NOT NULL',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['id']))
    )
    ->addConnection(
        new OneToManyConnection(
            'post',
            'user',
            ['author_id'],
            ['id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'post',
            'user',
            ['editor_id'],
            ['id']
        )
    );
