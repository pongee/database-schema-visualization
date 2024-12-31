<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\DataObject\Sql\Database\Table\Index;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SpatialIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SpatialIndexCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SpatialIndexInterface;

class SpatialIndexCollectionTest extends TestCase
{
    public function getSpatialIndexesProvider(): array
    {
        return [
            [
                new SpatialIndex('id', ['idx_id']),
            ],
            [
                new SpatialIndex('member_id', ['idx_member_id'], 'USING BTREE'),
            ],
            [
                new SpatialIndex('id', ['idx_id']),
                new SpatialIndex('member_id', ['idx_member_id'], 'USING BTREE'),
            ],
        ];
    }

    /**
     * @dataProvider getSpatialIndexesProvider
     */
    public function testCollection(SpatialIndexInterface ...$spatialIndexes): void
    {
        $sut = new SpatialIndexCollection();

        foreach ($spatialIndexes as $spatialIndex) {
            $sut->add($spatialIndex);
        }

        foreach ($sut as $item) {
            $this->assertInstanceOf(SpatialIndex::class, $item);
        }

        $this->assertCount(count($spatialIndexes), $sut->getIterator());
    }
}
