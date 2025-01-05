<?php

declare(strict_types=1);

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
                    'int',
                    [10],
                    'unsigned NOT NULL',
                    'The id'
                )
            )
            ->addColumn(
                new Column(
                    'email',
                    'varchar',
                    [64],
                    'COLLATE latin1_general_ci NOT NULL',
                    'The email'
                )
            )
            ->addColumn(
                new Column(
                    'password',
                    'varchar',
                    [32],
                    'COLLATE latin1_general_ci NOT NULL',
                    'The password'
                )
            )
            ->addColumn(
                new Column(
                    'nick',
                    'varchar',
                    [16],
                    'COLLATE latin1_general_ci DEFAULT NULL',
                    'The nick'
                )
            )
            ->addColumn(
                new Column(
                    'status',
                    'enum',
                    ['enabled', 'disabled'],
                    'COLLATE latin1_general_ci DEFAULT NULL',
                    'The status flag'
                )
            )
            ->addColumn(
                new Column(
                    'admin',
                    'bit',
                    [1],
                    'DEFAULT NULL',
                    'The admin flag'
                )
            )
            ->addColumn(
                new Column(
                    'geom',
                    'geometry',
                    [],
                    'NOT NULL',
                    'The geom'
                )
            )
            ->addColumn(
                new Column(
                    'fake_special_column',
                    'varchar',
                    [64],
                    'COLLATE latin1_general_ci NOT NULL',
                    '~!@#$%^&*()_+[];,./{}:"|\?<>'
                )
            )
            ->addColumn(
                new Column(
                    'fake_english_column',
                    'varchar',
                    [64],
                    'COLLATE latin1_general_ci NOT NULL',
                    'a b c d e f g h i j k l m n o p q r s t u v w x y z'
                )
            )
            ->addColumn(
                new Column(
                    'fake_chinese_column',
                    'varchar',
                    [64],
                    'CHARACTER SET utf8 NOT NULL',
                    '诶 比 西 迪 伊 艾弗 吉 艾尺 艾 杰 开 艾勒 艾马 艾娜 哦 屁 吉吾 艾儿 艾丝 提 伊吾 维 豆贝尔维 艾克斯 吾艾 贼德'
                )
            )
            ->addColumn(
                new Column(
                    'created_at',
                    'datetime',
                    [],
                    'DEFAULT NULL',
                    'The created at'
                )
            )
            ->addColumn(
                new Column(
                    'updated_at',
                    'datetime',
                    [],
                    'DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                    'The updated at'
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
