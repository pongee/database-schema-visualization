<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\DataObject\Sql\Database\Table\Index;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\UniqueIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\UniqueIndexCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\UniqueIndexInterface;

class UniqueIndexCollectionTest extends TestCase
{
    public function getUniqueIndexesProvider(): array
    {
        return [
            [
                new UniqueIndex('id', ['idx_id']),
            ],
            [
                new UniqueIndex('member_id', ['idx_member_id'], 'USING BTREE'),
            ],
            [
                new UniqueIndex('id', ['idx_id']),
                new UniqueIndex('member_id', ['idx_member_id'], 'USING BTREE'),
            ],
        ];
    }

    /**
     * @dataProvider getUniqueIndexesProvider
     */
    public function testCollection(UniqueIndexInterface ...$uniqueIndexes): void
    {
        $sut = new UniqueIndexCollection();

        foreach ($uniqueIndexes as $uniqueIndex) {
            $sut->add($uniqueIndex);
        }

        foreach ($sut as $item) {
            $this->assertInstanceOf(UniqueIndex::class, $item);
        }

        $this->assertCount(count($uniqueIndexes), $sut->getIterator());
    }
}
