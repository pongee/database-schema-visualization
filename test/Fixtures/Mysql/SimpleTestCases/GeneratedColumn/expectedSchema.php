<?php

declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;

return new Schema()
    ->addTable(
        new Table('invoice')
            ->addColumn(new Column('price', 'decimal', [10, 2], 'NOT NULL', ''))
            ->addColumn(new Column('qty', 'int', [11], 'NOT NULL', ''))
            ->addColumn(new Column('total', 'decimal', [12, 2], '', ''))
            ->addColumn(new Column('summary', 'varchar', [50], '', ''))
            ->addColumn(new Column('bumped', 'int', [11], '', ''))
            ->setPrimaryKey(new PrimaryKey(['price']))
    );
