<?php

declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;

return new Schema()
    ->addTable(
        new Table('airlines')
            ->addColumn(new Column('iata_code', 'CHAR', [2], 'DEFAULT NULL', ''))
            ->addColumn(new Column('airline', 'VARCHAR', [30], 'DEFAULT NULL', ''))
    )
    ->addTable(
        new Table('airports')
            ->addColumn(new Column('iata_code', 'CHAR', [3], 'DEFAULT NULL', ''))
            ->addColumn(new Column('airport', 'VARCHAR', [80], 'DEFAULT NULL', ''))
            ->addColumn(new Column('city', 'VARCHAR', [30], 'DEFAULT NULL', ''))
            ->addColumn(new Column('state', 'CHAR', [2], 'DEFAULT NULL', ''))
            ->addColumn(new Column('country', 'VARCHAR', [30], 'DEFAULT NULL', ''))
            ->addColumn(new Column('latitude', 'FLOAT', [], 'DEFAULT NULL', ''))
            ->addColumn(new Column('longitude', 'FLOAT', [], 'DEFAULT NULL', ''))
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
            ->addColumn(new Column('taxi_out', 'smallint', [6], 'DEFAULT NULL', ''))
            ->addColumn(new Column('wheels_off', 'char', [4], 'DEFAULT NULL', ''))
            ->addColumn(new Column('wheels_on', 'char', [4], 'DEFAULT NULL', ''))
            ->addColumn(new Column('taxi_in', 'smallint', [6], 'DEFAULT NULL', ''))
            ->addColumn(new Column('crs_arr_time', 'char', [4], 'DEFAULT NULL', ''))
            ->addColumn(new Column('arr_time', 'char', [4], 'DEFAULT NULL', ''))
            ->addColumn(new Column('arr_delay', 'smallint', [6], 'DEFAULT NULL', ''))
            ->addColumn(new Column('cancelled', 'smallint', [6], 'DEFAULT NULL', ''))
            ->addColumn(new Column('cancellation_code', 'char', [1], 'DEFAULT NULL', ''))
            ->addColumn(new Column('diverted', 'smallint', [6], 'DEFAULT NULL', ''))
            ->addColumn(new Column('crs_elapsed_time', 'smallint', [6], 'DEFAULT NULL', ''))
            ->addColumn(new Column('actual_elapsed_time', 'smallint', [6], 'DEFAULT NULL', ''))
            ->addColumn(new Column('air_time', 'smallint', [6], 'DEFAULT NULL', ''))
            ->addColumn(new Column('distance', 'smallint', [6], 'DEFAULT NULL', ''))
            ->addColumn(new Column('carrier_delay', 'smallint', [6], 'DEFAULT NULL', ''))
            ->addColumn(new Column('weather_delay', 'smallint', [6], 'DEFAULT NULL', ''))
            ->addColumn(new Column('nas_delay', 'smallint', [6], 'DEFAULT NULL', ''))
            ->addColumn(new Column('security_delay', 'smallint', [6], 'DEFAULT NULL', ''))
            ->addColumn(new Column('late_aircraft_delay', 'smallint', [6], 'DEFAULT NULL', ''))
    )
    ->addTable(
        new Table('tickets')
            ->addColumn(new Column('id', 'int', [11], 'unsigned NOT NULL AUTO_INCREMENT', ''))
            ->addColumn(new Column('fl_date', 'date', [], 'NOT NULL', ''))
            ->addColumn(new Column('fl_num', 'smallint', [6], 'NOT NULL', ''))
            ->addColumn(new Column('carrier', 'char', [2], "NOT NULL DEFAULT ''", ''))
            ->addColumn(new Column('origin', 'varchar', [5], "NOT NULL DEFAULT ''", ''))
            ->addColumn(new Column('dest', 'varchar', [5], "NOT NULL DEFAULT ''", ''))
            ->addColumn(new Column('price', 'decimal', [9, 2], 'NOT NULL DEFAULT 0.00', ''))
            ->setPrimaryKey(new PrimaryKey(['id']))
    )
    ->addTable(
        new Table('trips')
            ->addColumn(new Column('id', 'int', [11], 'unsigned NOT NULL AUTO_INCREMENT', ''))
            ->addColumn(new Column('ticket_id', 'int', [11], 'NOT NULL', ''))
            ->setPrimaryKey(new PrimaryKey(['id']))
    );
