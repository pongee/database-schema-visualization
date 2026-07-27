<?php

declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SimpleIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;

return new Schema()
    ->addTable(
        new Table('city')
            ->addColumn(
                new Column(
                    'ID',
                    'int',
                    [],
                    'NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'Name',
                    'char',
                    ['35'],
                    "NOT NULL DEFAULT ''",
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'CountryCode',
                    'char',
                    ['3'],
                    "NOT NULL DEFAULT ''",
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'District',
                    'char',
                    ['20'],
                    "NOT NULL DEFAULT ''",
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'Info',
                    'json',
                    [],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['ID']))
    )
    ->addTable(
        new Table('country')
            ->addColumn(
                new Column(
                    'Code',
                    'char',
                    ['3'],
                    "NOT NULL DEFAULT ''",
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'Name',
                    'char',
                    ['52'],
                    "NOT NULL DEFAULT ''",
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'Capital',
                    'int',
                    [],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'Code2',
                    'char',
                    ['2'],
                    "NOT NULL DEFAULT ''",
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['Code']))
    )
    ->addTable(
        new Table('countryinfo')
            ->addColumn(
                new Column(
                    'doc',
                    'json',
                    [],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    '_id',
                    'varbinary',
                    ['32'],
                    '',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    '_json_schema',
                    'json',
                    [],
                    '',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['_id']))
    )
    ->addTable(
        new Table('countrylanguage')
            ->addColumn(
                new Column(
                    'CountryCode',
                    'char',
                    ['3'],
                    "NOT NULL DEFAULT ''",
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'Language',
                    'char',
                    ['30'],
                    "NOT NULL DEFAULT ''",
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'Percentage',
                    'decimal',
                    ['4', '1'],
                    "NOT NULL DEFAULT '0.0'",
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'IsOfficial',
                    'enum',
                    ['T', 'F'],
                    "NOT NULL DEFAULT 'F'",
                    ''
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'CountryCode',
                    ['CountryCode']
                )
            )
            ->setPrimaryKey(new PrimaryKey(['CountryCode', 'Language']))
    )
    ->addConnection(
        new OneToManyConnection(
            'countrylanguage',
            'country',
            ['CountryCode'],
            ['Code']
        )
    );
