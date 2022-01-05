<?php declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\FulltextIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SimpleIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\UniqueIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;

return (new Schema())
    ->addTable(
        (new Table())
            ->setName('user')
            ->addColumn(
                new Column(
                    'id',
                    'INT',
                    [10],
                    'UNSIGNED NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'email',
                    'VARCHAR',
                    [64],
                    'COLLATE latin1_general_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'password',
                    'VARCHAR',
                    [32],
                    'COLLATE latin1_general_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'nick',
                    'VARCHAR',
                    [16],
                    'COLLATE latin1_general_ci DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'status',
                    'ENUM',
                    ['enabled', 'disabled'],
                    'COLLATE latin1_general_ci DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'admin',
                    'BIT',
                    [],
                    'NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'geom',
                    'GEOMETRY',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'created_at',
                    'DATETIME',
                    [],
                    'NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'updated_at',
                    'DATETIME',
                    [],
                    'NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['id']))
            ->addSimpleIndex(
                new SimpleIndex(
                    'i_password',
                    ['password']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'ih_password',
                    ['password']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'ib_password',
                    ['password']
                )
            )
            ->addFullTextIndex(
                new FulltextIndex(
                    'if_email_password',
                    ['email', 'password']
                )
            )
            ->addUniqueIndex(
                new UniqueIndex(
                    'iu_email_password',
                    ['nick']
                )
            )
            ->addUniqueIndex(
                new UniqueIndex(
                    'iuh_email_password',
                    ['nick']
                )
            )
            ->addUniqueIndex(
                new UniqueIndex(
                    'iub_email_password',
                    ['nick']
                )
            )
    );
