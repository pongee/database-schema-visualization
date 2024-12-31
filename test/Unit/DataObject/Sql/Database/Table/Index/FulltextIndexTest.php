<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\DataObject\Sql\Database\Table\Index;

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\FulltextIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\FulltextIndexInterface;

class FulltextIndexTest extends NamedIndexAbstract
{
    public function testInstanceOf(): void
    {
        $sut = new FulltextIndex('idx_id', ['id']);

        $this->assertInstanceOf(FulltextIndexInterface::class, $sut);
    }

    /**
     * @dataProvider getIndexProvider
     */
    public function testData(string $name, array $columns, $otherParameters = ''): void
    {
        $sut = new FulltextIndex($name, $columns, $otherParameters);

        $this->assertEquals($name, $sut->getName());
        $this->assertEquals($columns, $sut->getColumns());
        $this->assertEquals($otherParameters, $sut->getOtherParameters());
    }
}
