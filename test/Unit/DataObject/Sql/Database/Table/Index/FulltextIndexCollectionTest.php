<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\DataObject\Sql\Database\Table\Index;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\FulltextIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\FulltextIndexCollection;

class FulltextIndexCollectionTest extends TestCase
{
    public function getFulltextIndexesProvider(): array
    {
        return [
            [
                new FulltextIndex('id', ['idx_id']),
            ],
            [
                new FulltextIndex('member_id', ['idx_member_id'], 'USING BTREE'),
            ],
            [
                new FulltextIndex('id', ['idx_id']),
                new FulltextIndex('member_id', ['idx_member_id'], 'USING BTREE'),
            ],
        ];
    }

    /**
     * @dataProvider getFulltextIndexesProvider
     */
    public function testCollection(FulltextIndex ...$indexes): void
    {
        $sut = new FulltextIndexCollection();

        foreach ($indexes as $index) {
            $sut->add($index);
        }

        foreach ($sut as $item) {
            $this->assertInstanceOf(FulltextIndex::class, $item);
        }

        $this->assertCount(count($indexes), $sut->getIterator());
    }
}
