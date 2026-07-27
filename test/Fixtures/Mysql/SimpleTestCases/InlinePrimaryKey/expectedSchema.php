<?php

declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;

return new Schema()
    ->addTable(
        new Table()
            ->setName('session')
            ->addColumn(
                new Column(
                    'id',
                    'int',
                    ['10'],
                    'NOT NULL AUTO_INCREMENT PRIMARY KEY',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'token',
                    'varchar',
                    ['64'],
                    'NOT NULL',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['id']))
    );
