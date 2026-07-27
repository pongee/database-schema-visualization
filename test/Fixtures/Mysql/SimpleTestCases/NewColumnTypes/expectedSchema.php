<?php

declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;

return new Schema()
    ->addTable(
        new Table()
            ->setName('metrics')
            ->addColumn(
                new Column(
                    'id',
                    'SERIAL',
                    [],
                    '',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'score',
                    'NUMERIC',
                    ['10', '2'],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'ratio',
                    'REAL',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'amount',
                    'DEC',
                    ['8', '2'],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'weight',
                    'FIXED',
                    ['6', '3'],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'tiny_flag',
                    'INT1',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'big_value',
                    'INT8',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'area',
                    'GEOMETRYCOLLECTION',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'embedding',
                    'VECTOR',
                    ['3'],
                    'NOT NULL',
                    ''
                )
            )
    );
