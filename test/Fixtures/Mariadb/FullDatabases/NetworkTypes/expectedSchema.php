<?php

declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SimpleIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\UniqueIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;

return new Schema()
    ->addTable(
        new Table('device')
            ->addColumn(
                new Column(
                    'id',
                    'UUID',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'hostname',
                    'varchar',
                    [255],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'ipv4',
                    'INET4',
                    [],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'ipv6',
                    'INET6',
                    [],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['id']))
            ->addUniqueIndex(
                new UniqueIndex(
                    'uq_hostname',
                    ['hostname']
                )
            )
    )
    ->addTable(
        new Table('device_interface')
            ->addColumn(
                new Column(
                    'id',
                    'UUID',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'device_id',
                    'UUID',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'address',
                    'INET6',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['id']))
            ->addSimpleIndex(
                new SimpleIndex(
                    'fk_device_id',
                    ['device_id']
                )
            )
    )
    ->addConnection(
        new OneToManyConnection(
            'device_interface',
            'device',
            ['device_id'],
            ['id']
        )
    );
