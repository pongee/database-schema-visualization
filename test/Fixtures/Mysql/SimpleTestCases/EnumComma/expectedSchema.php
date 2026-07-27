<?php

declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;

return new Schema()
    ->addTable(
        new Table('ticket')
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
                    'status',
                    'enum',
                    ['active', 'on,hold', 'closed'],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'tags',
                    'set',
                    ['a,b', 'c'],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['id']))
    );
