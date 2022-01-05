<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\Export;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToOneConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\FulltextIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SimpleIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SpatialIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\UniqueIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\SchemaInterface;
use Pongee\DatabaseSchemaVisualization\Export\Json;

class JsonTest extends TestCase
{
    public function getSchamaProvider(): array
    {
        return [
            [
                (new Schema())
                    ->addTable(
                        (new Table())
                            ->setName('member')
                            ->addColumn(new Column('id', 'INT', [10], 'NOT NULL DEFAULT', 'The id'))
                    ),
                '
{
    "tables": {
        "member": {
            "columns": [
                {
                    "name": "id",
                    "type": "INT",
                    "typeParameters": [10],
                    "otherParameters": "NOT NULL DEFAULT",
                    "comment": "The id"
                }
            ],
            "indexes": {"simple": [], "spatial": [], "fulltext": [], "unique": []},
            "primaryKey": []
        }
    },
    "connections": []
}
',
            ],
            [
                (new Schema())
                    ->addTable(
                        (new Table())
                            ->setName('member')
                            ->addColumn(new Column('id', 'INT', [10], 'NOT NULL DEFAULT', 'The id'))
                    )
                    ->addTable(
                        (new Table())
                            ->setName('member_data')
                            ->addColumn(new Column('id', 'INT', [10], 'NOT NULL DEFAULT', ''))
                            ->addColumn(new Column('member_id', 'INT', [10], 'NOT NULL', ''))
                            ->addColumn(new Column('type', 'VARCHAR', [64], 'NOT NULL', ''))
                            ->addColumn(new Column('status', 'ENUM', ['enabled', 'deleted'], 'DEFAULT NULL', ''))
                            ->setPrimaryKey(new PrimaryKey(['id'], 'USING HASH'))
                            ->addSimpleIndex(new SimpleIndex('idx_member_id', ['member_id'], 'USING HASH'))
                            ->addFullTextIndex(new FulltextIndex('idx_status', ['status']))
                            ->addSpatialIndex(new SpatialIndex('idx_type', ['type']))
                            ->addUniqueIndex(new UniqueIndex('idx_member_id', ['member_id'], 'USING HASH'))
                    )
                    ->addTable(
                        (new Table())
                            ->setName('member_log')
                            ->addColumn(new Column('id', 'INT', [10], 'NOT NULL DEFAULT', 'The id'))
                            ->addColumn(new Column('member_id', 'INT', [10], 'NOT NULL', 'The member id'))
                            ->addColumn(new Column('log', 'VARCHAR', [255], 'NOT NULL', 'The log'))
                            ->setPrimaryKey(new PrimaryKey(['id'], 'USING HASH'))
                            ->addSimpleIndex(new SimpleIndex('idx_member_id', ['member_id'], 'USING HASH'))
                    )
                    ->addConnection(
                        new OneToOneConnection('member_data', 'member', ['member_id'], ['id'])
                    )
                    ->addConnection(
                        new OneToManyConnection('member_log', 'member', ['member_id'], ['id'])
                    ),
                '
{
    "tables": {
        "member": {
            "columns": [
                {
                    "name": "id",
                    "type": "INT",
                    "typeParameters": [10],
                    "otherParameters": "NOT NULL DEFAULT",
                    "comment": "The id"
                }
            ],
            "indexes": {"simple": [], "spatial": [], "fulltext": [], "unique": []},
            "primaryKey": []
        },
        "member_data": {
            "columns": [
                {
                    "name": "id",
                    "type": "INT",
                    "typeParameters": [10],
                    "otherParameters": "NOT NULL DEFAULT",
                    "comment": ""
                },
                {
                    "name": "member_id",
                    "type": "INT",
                    "typeParameters": [10],
                    "otherParameters": "NOT NULL",
                    "comment": ""
                },
                {
                    "name": "type",
                    "type": "VARCHAR",
                    "typeParameters": [64],
                    "otherParameters": "NOT NULL",
                    "comment": ""
                },
                {
                    "name": "status",
                    "type": "ENUM",
                    "typeParameters": ["enabled","deleted"],
                    "otherParameters": "DEFAULT NULL",
                    "comment": ""
                }
            ],
            "indexes": {
                "simple": [
                    {
                        "name": "idx_member_id",
                        "columns": ["member_id"],
                        "otherParameters": "USING HASH"
                    }
                ],
                "spatial": [
                    {
                        "name": "idx_type",
                        "columns": [
                            "type"
                        ],
                        "otherParameters": ""
                    }
                ],
                "fulltext": [
                    {
                        "name": "idx_status",
                        "columns": [
                            "status"
                        ],
                        "otherParameters": ""
                    }
                ],
                "unique": [
                    {
                        "name": "idx_member_id",
                        "columns": ["member_id"],
                        "otherParameters": "USING HASH"
                    }
                ]
            },
            "primaryKey": {
                "columns": ["id"],
                "otherParameters": "USING HASH"
            }
        },
        "member_log": {
            "columns": [
                {
                    "name": "id",
                    "type": "INT",
                    "typeParameters": [10],
                    "otherParameters": "NOT NULL DEFAULT",
                    "comment": "The id"
                },
                {
                    "name": "member_id",
                    "type": "INT",
                    "typeParameters": [10],
                    "otherParameters": "NOT NULL",
                    "comment": "The member id"
                },
                {
                    "name": "log",
                    "type": "VARCHAR",
                    "typeParameters": [255],
                    "otherParameters": "NOT NULL",
                    "comment": "The log"
                }
            ],
            "indexes": {
                "simple": [
                    {
                        "name": "idx_member_id",
                        "columns": ["member_id"],
                        "otherParameters": "USING HASH"
                    }
                ],
                "spatial": [],
                "fulltext": [],
                "unique": []
            },
            "primaryKey": {
                "columns": ["id"],
                "otherParameters": "USING HASH"
            }
        }
    },
    "connections": [
        {
            "type": "OneToOne",
            "childTableName": "member_data",
            "childTableColumns": ["member_id"],
            "parentTableName": "member",
            "parentTableColumns": ["id"]
        },
        {
            "type": "OneToMany",
            "childTableName": "member_log",
            "childTableColumns": ["member_id"],
            "parentTableName": "member",
            "parentTableColumns": ["id"]
        }
    ]
}
',
            ],
        ];
    }

    /**
     * @dataProvider getSchamaProvider
     */
    public function testExportTableWithColumns(SchemaInterface $schema, string $expectedJson)
    {
        $sut = new Json();

        $this->assertJsonStringEqualsJsonString($expectedJson, $sut->export($schema));
    }
}
