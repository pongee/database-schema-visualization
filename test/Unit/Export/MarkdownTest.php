<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\Export;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SimpleIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\UniqueIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\SchemaInterface;
use Pongee\DatabaseSchemaVisualization\Export\Markdown;

class MarkdownTest extends TestCase
{
    public static function getSchemaProvider(): array
    {
        return [
            'single table with a column' => [
                new Schema()
                    ->addTable(
                        new Table()
                            ->setName('member')
                            ->addColumn(new Column('id', 'INT', ['10'], 'NOT NULL', 'The id'))
                    ),
                <<<'MD'
                    # Schema

                    ## `member` table

                    ### Columns

                    | Name | Type | Parameters | Comment |
                    | --- | --- | --- | --- |
                    | id | INT ( 10 ) | NOT NULL | The id |

                    MD,
            ],
            'tables with keys, indexes and a connection' => [
                new Schema()
                    ->addTable(
                        new Table()
                            ->setName('tag')
                            ->addColumn(new Column('id', 'INT', ['11'], 'unsigned NOT NULL AUTO_INCREMENT', ''))
                            ->addColumn(new Column('uuid', 'BINARY', ['16'], 'NOT NULL', ''))
                            ->addColumn(new Column('name', 'VARCHAR', ['64'], 'NOT NULL', 'The name'))
                            ->addUniqueIndex(new UniqueIndex('uk_uuid', ['uuid']))
                            ->addUniqueIndex(new UniqueIndex('uk_tag_name', ['name']))
                            ->setPrimaryKey(new PrimaryKey(['id']))
                    )
                    ->addTable(
                        new Table()
                            ->setName('performer_tag')
                            ->addColumn(new Column('id', 'INT', ['11'], 'unsigned NOT NULL AUTO_INCREMENT', ''))
                            ->addColumn(new Column('tag_id', 'INT', ['11'], 'unsigned NOT NULL', ''))
                            ->addSimpleIndex(new SimpleIndex('idx_tag_id', ['tag_id']))
                            ->setPrimaryKey(new PrimaryKey(['id']))
                    )
                    ->addConnection(new OneToManyConnection('performer_tag', 'tag', ['tag_id'], ['id'])),
                <<<'MD'
                    # Schema

                    ## `tag` table

                    ### Columns

                    | Name | Type | Parameters | Comment |
                    | --- | --- | --- | --- |
                    | id | INT ( 11 ) | unsigned NOT NULL AUTO_INCREMENT | - |
                    | uuid | BINARY ( 16 ) | NOT NULL | - |
                    | name | VARCHAR ( 64 ) | NOT NULL | The name |

                    ### Primary Key

                    | Columns | Parameters |
                    | --- | --- |
                    | id | - |

                    ### Unique Indexes

                    | Name | Columns | Parameters |
                    | --- | --- | --- |
                    | uk_uuid | uuid | - |
                    | uk_tag_name | name | - |

                    ## `performer_tag` table

                    ### Columns

                    | Name | Type | Parameters | Comment |
                    | --- | --- | --- | --- |
                    | id | INT ( 11 ) | unsigned NOT NULL AUTO_INCREMENT | - |
                    | tag_id | INT ( 11 ) | unsigned NOT NULL | - |

                    ### Primary Key

                    | Columns | Parameters |
                    | --- | --- |
                    | id | - |

                    ### Indexes

                    | Name | Columns | Parameters |
                    | --- | --- | --- |
                    | idx_tag_id | tag_id | - |

                    ## Connections

                    | Type | Child | Parent |
                    | --- | --- | --- |
                    | OneToMany | performer_tag ( tag_id ) | tag ( id ) |

                    MD,
            ],
        ];
    }

    #[DataProvider('getSchemaProvider')]
    public function testExport(SchemaInterface $schema, string $expectedMarkdown): void
    {
        $sut = new Markdown(
            file_get_contents(__DIR__ . '/../../../src/Template/Markdown/v1.twig')
        );

        $this->assertSame($expectedMarkdown, $sut->export($schema));
    }
}
