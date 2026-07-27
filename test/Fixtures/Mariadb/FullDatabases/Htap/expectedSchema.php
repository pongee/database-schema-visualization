<?php

declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\UniqueIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;

return new Schema()
    ->addTable(
        new Table('airlines')
            ->addColumn(new Column('iata_code', 'char', [2], 'DEFAULT NULL', ''))
            ->addColumn(new Column('airline', 'varchar', [30], 'DEFAULT NULL', ''))
            ->addUniqueIndex(new UniqueIndex('idx_iata_code', ['iata_code']))
    )
    ->addTable(
        new Table('airports')
            ->addColumn(new Column('iata_code', 'char', [3], 'DEFAULT NULL', ''))
            ->addColumn(new Column('airport', 'varchar', [80], 'DEFAULT NULL', ''))
            ->addColumn(new Column('city', 'varchar', [30], 'DEFAULT NULL', ''))
            ->addColumn(new Column('state', 'char', [2], 'DEFAULT NULL', ''))
            ->addColumn(new Column('country', 'varchar', [30], 'DEFAULT NULL', ''))
            ->addColumn(new Column('latitude', 'float', [], 'DEFAULT NULL', ''))
            ->addColumn(new Column('longitude', 'float', [], 'DEFAULT NULL', ''))
    )
    ->addTable(
        new Table('flights')
            ->addColumn(new Column('year', 'smallint', [6], 'DEFAULT NULL', ''))
            ->addColumn(new Column('month', 'tinyint', [4], 'DEFAULT NULL', ''))
            ->addColumn(new Column('day', 'tinyint', [4], 'DEFAULT NULL', ''))
            ->addColumn(new Column('day_of_week', 'tinyint', [4], 'DEFAULT NULL', ''))
            ->addColumn(new Column('fl_date', 'date', [], 'DEFAULT NULL', ''))
            ->addColumn(new Column('carrier', 'char', [2], 'DEFAULT NULL', ''))
            ->addColumn(new Column('tail_num', 'char', [6], 'DEFAULT NULL', ''))
            ->addColumn(new Column('fl_num', 'smallint', [6], 'DEFAULT NULL', ''))
            ->addColumn(new Column('origin', 'varchar', [5], 'DEFAULT NULL', ''))
            ->addColumn(new Column('dest', 'varchar', [5], 'DEFAULT NULL', ''))
            ->addColumn(new Column('crs_dep_time', 'char', [4], 'DEFAULT NULL', ''))
            ->addColumn(new Column('dep_time', 'char', [4], 'DEFAULT NULL', ''))
            ->addColumn(new Column('dep_delay', 'smallint', [6], 'DEFAULT NULL', ''))
    );
