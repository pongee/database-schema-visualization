<?php

declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SimpleIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\UniqueIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;

return new Schema()
    ->addTable(
        new Table('account')
            ->addColumn(
                new Column(
                    'id',
                    'int',
                    [10],
                    'unsigned NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'email',
                    'varchar',
                    [255],
                    'NOT NULL',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['id']))
            ->addUniqueIndex(
                new UniqueIndex(
                    'uq_email',
                    ['email']
                )
            )
    )
    ->addTable(
        new Table('account_role')
            ->addColumn(
                new Column(
                    'id',
                    'int',
                    [10],
                    'unsigned NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'account_id',
                    'int',
                    [10],
                    'unsigned NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'role',
                    'varchar',
                    [32],
                    'NOT NULL',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['id']))
            ->addSimpleIndex(
                new SimpleIndex(
                    'fk_account_id',
                    ['account_id']
                )
            )
    )
    ->addConnection(
        new OneToManyConnection(
            'account_role',
            'account',
            ['account_id'],
            ['id']
        )
    );
