<?php declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SimpleIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;

return (new Schema())
    ->addTable(
        (new Table())
            ->setName('city')
            ->addColumn(
                new Column(
                    'ID',
                    'INT',
                    [11],
                    'NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'Name',
                    'CHAR',
                    [35],
                    "NOT NULL DEFAULT ''",
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'CountryCode',
                    'CHAR',
                    [3],
                    "NOT NULL DEFAULT ''",
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'District',
                    'CHAR',
                    [20],
                    "NOT NULL DEFAULT ''",
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'Population',
                    'INT',
                    [11],
                    "NOT NULL DEFAULT '0'",
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['ID']))
            ->addSimpleIndex(
                new SimpleIndex(
                    'CountryCode',
                    ['CountryCode']
                )
            )
    )
    ->addConnection(
        new OneToManyConnection(
            'city',
            'country',
            ['CountryCode'],
            ['Code']
        )
    )
    ->addTable(
        (new Table())
            ->setName('country')
            ->addColumn(
                new Column(
                    'Code',
                    'CHAR',
                    [3],
                    "NOT NULL DEFAULT ''",
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'Name',
                    'CHAR',
                    [52],
                    "NOT NULL DEFAULT ''",
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'Continent',
                    'enum',
                    ['Asia', 'Europe', 'North America', 'Africa', 'Oceania', 'Antarctica', 'South America'],
                    "NOT NULL DEFAULT 'Asia'",
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'Region',
                    'CHAR',
                    [26],
                    "NOT NULL DEFAULT ''",
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'SurfaceArea',
                    'FLOAT',
                    [10, 2],
                    "NOT NULL DEFAULT '0.00'",
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'IndepYear',
                    'SMALLINT',
                    [6],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'Population',
                    'INT',
                    [11],
                    "NOT NULL DEFAULT '0'",
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'LifeExpectancy',
                    'FLOAT',
                    [3, 1],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'GNP',
                    'FLOAT',
                    [10, 2],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'GNPOld',
                    'FLOAT',
                    [10, 2],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'LocalName',
                    'CHAR',
                    [45],
                    "NOT NULL DEFAULT ''",
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'GovernmentForm',
                    'CHAR',
                    [45],
                    "NOT NULL DEFAULT ''",
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'HeadOfState',
                    'CHAR',
                    [60],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'Capital',
                    'INT',
                    [11],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'Code2',
                    'CHAR',
                    [2],
                    "NOT NULL DEFAULT ''",
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['Code']))
    )
    ->addTable(
        (new Table())
            ->setName('countrylanguage')
            ->addColumn(
                new Column(
                    'CountryCode',
                    'CHAR',
                    [3],
                    "NOT NULL DEFAULT ''",
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'Language',
                    'CHAR',
                    [30],
                    "NOT NULL DEFAULT ''",
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
            ->addColumn(
                new Column(
                    'Percentage',
                    'FLOAT',
                    [4, 1],
                    "NOT NULL DEFAULT '0.0'",
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['CountryCode', 'Language']))
            ->addSimpleIndex(
                new SimpleIndex(
                    'CountryCode',
                    ['CountryCode']
                )
            )
    )
    ->addConnection(
        new OneToManyConnection(
            'countrylanguage',
            'country',
            ['CountryCode'],
            ['Code']
        )
    );
