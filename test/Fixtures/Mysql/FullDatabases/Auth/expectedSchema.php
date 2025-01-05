<?php

declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SimpleIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;

return (new Schema())
    ->addTable(
        (new Table())
            ->setName('user')
            ->addColumn(
                new Column(
                    'user_id',
                    'int',
                    [10],
                    'unsigned NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'first_name',
                    'varchar',
                    [45],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'last_name',
                    'varchar',
                    [45],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'last_update',
                    'timestamp',
                    [],
                    'NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['user_id']))
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_actor_last_name',
                    ['last_name']
                )
            )
    )
    ->addTable(
        (new Table())
            ->setName('developer')
            ->addColumn(
                new Column(
                    'id',
                    'int',
                    [10],
                    'unsigned NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'email',
                    'varchar',
                    [64],
                    'COLLATE latin1_general_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'password',
                    'varchar',
                    [32],
                    'COLLATE latin1_general_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'nick',
                    'varchar',
                    [16],
                    'COLLATE latin1_general_ci DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'status',
                    'enum',
                    ['enabled', 'disabled'],
                    'COLLATE latin1_general_ci DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'user_id',
                    'int',
                    [10],
                    'unsigned NOT NULL',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['id']))
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_email_password',
                    ['email', 'password']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'fk_user_id',
                    ['user_id']
                )
            )
    )
    ->addTable(
        (new Table())
            ->setName('log')
            ->addColumn(
                new Column(
                    'id',
                    'int',
                    [10],
                    'unsigned NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'message',
                    'varchar',
                    [64],
                    'COLLATE latin1_general_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'user_id',
                    'int',
                    [10],
                    'unsigned NOT NULL',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['id']))
    )
    ->addConnection(
        new OneToManyConnection(
            'developer',
            'user',
            ['user_id'],
            ['user_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'log',
            'user',
            ['user_id'],
            ['user_id']
        )
    );
