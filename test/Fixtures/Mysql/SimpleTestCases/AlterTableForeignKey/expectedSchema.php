<?php declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
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
                    'NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['user_id']))
    )
    ->addTable(
        (new Table())
            ->setName('log')
            ->addColumn(
                new Column(
                    'id',
                    'int',
                    [10],
                    'NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'log_user_id',
                    'int',
                    [10],
                    'NOT NULL',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['id']))
    )
    ->addConnection(
        new OneToManyConnection(
            'log',
            'user',
            ['log_user_id'],
            ['user_id']
        )
    );
