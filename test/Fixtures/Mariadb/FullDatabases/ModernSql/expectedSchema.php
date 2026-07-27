<?php

declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;

return new Schema()
    ->addTable(
        new Table('supers')
            ->addColumn(new Column('id', 'int', [11], 'unsigned NOT NULL AUTO_INCREMENT', ''))
            ->addColumn(new Column('name', 'varchar', [100], "NOT NULL DEFAULT ''", ''))
            ->addColumn(new Column('type', 'char', [1], "NOT NULL DEFAULT ''", ''))
            ->addColumn(new Column('rescues', 'int', [11], 'NOT NULL', ''))
            ->addColumn(new Column('mentor', 'int', [11], 'DEFAULT NULL', ''))
            ->addColumn(new Column('startDate', 'datetime', [], 'NOT NULL', ''))
            ->addColumn(new Column('endDate', 'datetime', [], 'NOT NULL', ''))
            ->setPrimaryKey(new PrimaryKey(['id']))
    )
    ->addTable(
        new Table('supersteams')
            ->addColumn(new Column('superid', 'int', [11], 'unsigned NOT NULL', ''))
            ->addColumn(new Column('teamid', 'int', [11], 'unsigned NOT NULL', ''))
    )
    ->addTable(
        new Table('teams')
            ->addColumn(new Column('id', 'int', [11], 'unsigned NOT NULL AUTO_INCREMENT', ''))
            ->addColumn(new Column('name', 'varchar', [50], "NOT NULL DEFAULT ''", ''))
            ->setPrimaryKey(new PrimaryKey(['id']))
    );
