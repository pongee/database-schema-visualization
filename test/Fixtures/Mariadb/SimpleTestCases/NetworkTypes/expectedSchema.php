<?php

declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
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
    );
