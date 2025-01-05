<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\DataObject\Sql\Database\Table\Index;

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SpatialIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SpatialIndexInterface;

class SpatialIndexTest extends NamedIndexAbstract
{
    public function testInstanceOf(): void
    {
        $sut = new SpatialIndex('idx_id', ['id']);

        $this->assertInstanceOf(SpatialIndexInterface::class, $sut);
    }

    /**
     * @dataProvider getIndexProvider
     */
    public function testData(string $name, array $columns, string $otherParameters = ''): void
    {
        $sut = new SpatialIndex($name, $columns, $otherParameters);

        $this->assertEquals($name, $sut->getName());
        $this->assertEquals($columns, $sut->getColumns());
        $this->assertEquals($otherParameters, $sut->getOtherParameters());
    }
}
