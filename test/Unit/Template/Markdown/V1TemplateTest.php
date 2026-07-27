<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\Template\Markdown;

use PHPUnit\Framework\Attributes\DataProvider;
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
use Pongee\DatabaseSchemaVisualization\Export\Markdown;

class V1TemplateTest extends TestCase
{
    public static function getSchemaProvider(): array
    {
        return [
            'columns only' => [
                new Schema()
                    ->addTable(
                        new Table()
                            ->setName('actor')
                            ->addColumn(new Column('actor_id', 'SMALLINT', [], 'UNSIGNED NOT NULL AUTO_INCREMENT', ''))
                            ->addColumn(new Column('first_name', 'VARCHAR', [45], 'NOT NULL', ''))
                            ->addColumn(new Column('last_name', 'VARCHAR', [45], 'NOT NULL', ''))
                            ->addColumn(
                                new Column(
                                    'last_update',
                                    'TIMESTAMP',
                                    [],
                                    'NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                                    ''
                                )
                            )
                    ),
                <<<'MD'
                    # Schema

                    ## `actor` table

                    ### Columns

                    | Name | Type | Parameters | Comment |
                    | --- | --- | --- | --- |
                    | actor_id | SMALLINT | UNSIGNED NOT NULL AUTO_INCREMENT | - |
                    | first_name | VARCHAR ( 45 ) | NOT NULL | - |
                    | last_name | VARCHAR ( 45 ) | NOT NULL | - |
                    | last_update | TIMESTAMP | NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | - |

                    MD,
            ],
            'every section and connection' => [
                new Schema()
                    ->addTable(
                        new Table()
                            ->setName('member')
                            ->addColumn(new Column('id', 'INT', [10], 'NOT NULL DEFAULT', ''))
                            ->setPrimaryKey(new PrimaryKey(['id']))
                    )
                    ->addTable(
                        new Table()
                            ->setName('member_data')
                            ->addColumn(new Column('id', 'INT', [10], 'NOT NULL DEFAULT', ''))
                            ->addColumn(new Column('member_id', 'INT', [10], 'NOT NULL', ''))
                            ->addColumn(new Column('type', 'VARCHAR', [64], 'NOT NULL', ''))
                            ->addColumn(new Column('status', 'ENUM', ['enabled', 'deleted'], 'DEFAULT NULL', ''))
                            ->setPrimaryKey(new PrimaryKey(['id'], 'USING HASH'))
                            ->addSimpleIndex(new SimpleIndex('idx_type', ['type']))
                            ->addSimpleIndex(new SimpleIndex('idx_type_status', ['type', 'status'], 'USING HASH'))
                            ->addUniqueIndex(new UniqueIndex('idx_member_id', ['member_id']))
                    )
                    ->addTable(
                        new Table()
                            ->setName('member_log')
                            ->addColumn(new Column('id', 'INT', [10], 'NOT NULL DEFAULT', ''))
                            ->addColumn(new Column('member_id', 'INT', [10], 'NOT NULL', ''))
                            ->addColumn(new Column('created_at', 'DATETIME', [], 'NOT NULL', ''))
                            ->setPrimaryKey(new PrimaryKey(['id'], 'USING HASH'))
                            ->addSimpleIndex(new SimpleIndex('idx_action', ['action']))
                            ->addUniqueIndex(new UniqueIndex('idx_member_id', ['member_id'], 'USING HASH'))
                            ->addFullTextIndex(new FulltextIndex('idx_member_id_action', ['member_id', 'action']))
                            ->addSpatialIndex(new SpatialIndex('idx_message', ['message']))
                    )
                    ->addConnection(new OneToOneConnection('member_data', 'member', ['member_id'], ['id']))
                    ->addConnection(new OneToManyConnection('member_log', 'member', ['member_id'], ['id'])),
                <<<'MD'
                    # Schema

                    ## `member` table

                    ### Columns

                    | Name | Type | Parameters | Comment |
                    | --- | --- | --- | --- |
                    | id | INT ( 10 ) | NOT NULL DEFAULT | - |

                    ### Primary Key

                    | Columns | Parameters |
                    | --- | --- |
                    | id | - |

                    ## `member_data` table

                    ### Columns

                    | Name | Type | Parameters | Comment |
                    | --- | --- | --- | --- |
                    | id | INT ( 10 ) | NOT NULL DEFAULT | - |
                    | member_id | INT ( 10 ) | NOT NULL | - |
                    | type | VARCHAR ( 64 ) | NOT NULL | - |
                    | status | ENUM ( enabled, deleted ) | DEFAULT NULL | - |

                    ### Primary Key

                    | Columns | Parameters |
                    | --- | --- |
                    | id | USING HASH |

                    ### Indexes

                    | Name | Columns | Parameters |
                    | --- | --- | --- |
                    | idx_type | type | - |
                    | idx_type_status | type, status | USING HASH |

                    ### Unique Indexes

                    | Name | Columns | Parameters |
                    | --- | --- | --- |
                    | idx_member_id | member_id | - |

                    ## `member_log` table

                    ### Columns

                    | Name | Type | Parameters | Comment |
                    | --- | --- | --- | --- |
                    | id | INT ( 10 ) | NOT NULL DEFAULT | - |
                    | member_id | INT ( 10 ) | NOT NULL | - |
                    | created_at | DATETIME | NOT NULL | - |

                    ### Primary Key

                    | Columns | Parameters |
                    | --- | --- |
                    | id | USING HASH |

                    ### Indexes

                    | Name | Columns | Parameters |
                    | --- | --- | --- |
                    | idx_action | action | - |

                    ### Unique Indexes

                    | Name | Columns | Parameters |
                    | --- | --- | --- |
                    | idx_member_id | member_id | USING HASH |

                    ### Fulltext Indexes

                    | Name | Columns | Parameters |
                    | --- | --- | --- |
                    | idx_member_id_action | member_id, action | - |

                    ### Spatial Indexes

                    | Name | Columns | Parameters |
                    | --- | --- | --- |
                    | idx_message | message | - |

                    ## Connections

                    | Type | Child | Parent |
                    | --- | --- | --- |
                    | OneToOne | member_data ( member_id ) | member ( id ) |
                    | OneToMany | member_log ( member_id ) | member ( id ) |

                    MD,
            ],
            'new types, composite primary key and multi-column index' => [
                new Schema()
                    ->addTable(
                        new Table()
                            ->setName('measurement')
                            ->addColumn(new Column('id', 'SERIAL', [], '', ''))
                            ->addColumn(new Column('sensor_id', 'INT', [10], 'NOT NULL', ''))
                            ->addColumn(new Column('score', 'NUMERIC', [10, 2], 'NOT NULL', ''))
                            ->addColumn(new Column('area', 'GEOMETRYCOLLECTION', [], 'NOT NULL', ''))
                            ->addColumn(new Column('embedding', 'VECTOR', [3], 'NOT NULL', ''))
                            ->addColumn(new Column('label', 'VARCHAR', [64], '', ''))
                            ->setPrimaryKey(new PrimaryKey(['sensor_id', 'id']))
                            ->addSimpleIndex(new SimpleIndex('idx_sensor_score_label', ['sensor_id', 'score', 'label']))
                            ->addSpatialIndex(new SpatialIndex('idx_area', ['area']))
                    ),
                <<<'MD'
                    # Schema

                    ## `measurement` table

                    ### Columns

                    | Name | Type | Parameters | Comment |
                    | --- | --- | --- | --- |
                    | id | SERIAL | - | - |
                    | sensor_id | INT ( 10 ) | NOT NULL | - |
                    | score | NUMERIC ( 10, 2 ) | NOT NULL | - |
                    | area | GEOMETRYCOLLECTION | NOT NULL | - |
                    | embedding | VECTOR ( 3 ) | NOT NULL | - |
                    | label | VARCHAR ( 64 ) | - | - |

                    ### Primary Key

                    | Columns | Parameters |
                    | --- | --- |
                    | sensor_id, id | - |

                    ### Indexes

                    | Name | Columns | Parameters |
                    | --- | --- | --- |
                    | idx_sensor_score_label | sensor_id, score, label | - |

                    ### Spatial Indexes

                    | Name | Columns | Parameters |
                    | --- | --- | --- |
                    | idx_area | area | - |

                    MD,
            ],
        ];
    }

    #[DataProvider('getSchemaProvider')]
    public function testExport(SchemaInterface $schema, string $expectedMarkdown): void
    {
        $template = file_get_contents(__DIR__ . '/../../../../src/Template/Markdown/v1.twig');

        $sut = new Markdown($template);

        $this->assertSame($expectedMarkdown, $sut->export($schema));
    }
}
