<?php

declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;

return new Schema()
    ->addTable(
        new Table('user profile')
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
                    'user_id',
                    'int',
                    ['10'],
                    'NOT NULL',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['id']))
    );
