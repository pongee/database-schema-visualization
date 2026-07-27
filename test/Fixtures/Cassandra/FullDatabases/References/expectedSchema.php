<?php

declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;

return new Schema()
    ->addTable(
        new Table('message')
            ->addColumn(
                new Column(
                    'id',
                    'VARCHAR',
                    [32],
                    '',
                    ' CQL: UUID'
                )
            )
            ->addColumn(
                new Column(
                    'sometext',
                    'text',
                    [],
                    '',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'othertext',
                    'VARCHAR',
                    [],
                    '',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'created',
                    'TIMESTAMP',
                    [],
                    '',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'flags',
                    'map',
                    [
                        'VARCHAR',
                        'boolean',
                    ],
                    '',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'data',
                    'map',
                    [
                        'varchar',
                        'varchar',
                    ],
                    '',
                    ''
                )
            )
    )
    ->addTable(
        new Table('user_messages')
            ->addColumn(
                new Column(
                    'user_id',
                    'VARCHAR',
                    [32],
                    '',
                    ' CQL: UUID'
                )
            )
            ->addColumn(
                new Column(
                    'type_id',
                    'varchar',
                    [],
                    '',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'messages',
                    'map',
                    ['UUID', 'message'],
                    '',
                    'CQL: frozen'
                )
            )
            ->setPrimaryKey(new PrimaryKey(['user_id', 'type_id']))
    )
    ->addConnection(
        new OneToManyConnection(
            'user_messages',
            'message',
            [],
            []
        )
    );
