<?php

declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;

return new Schema()
    ->addTable(
        new Table('note')
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
                    'body',
                    'varchar',
                    [255],
                    'NOT NULL',
                    "it's a note"
                )
            )
            ->addColumn(
                new Column(
                    'label',
                    'varchar',
                    [64],
                    'DEFAULT NULL',
                    "a'b"
                )
            )
            ->setPrimaryKey(new PrimaryKey(['id']))
    );
