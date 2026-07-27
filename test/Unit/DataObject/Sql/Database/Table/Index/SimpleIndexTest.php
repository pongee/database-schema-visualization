<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\DataObject\Sql\Database\Table\Index;

use PHPUnit\Framework\Attributes\DataProvider;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SimpleIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SimpleIndexInterface;

class SimpleIndexTest extends NamedIndexAbstract
{
    public function testInstanceOf(): void
    {
        $sut = new SimpleIndex('idx_id', ['id']);

        $this->assertInstanceOf(SimpleIndexInterface::class, $sut);
    }

    #[DataProvider('getIndexProvider')]
    public function testData(string $name, array $columns, string $otherParameters = ''): void
    {
        $sut = new SimpleIndex($name, $columns, $otherParameters);

        $this->assertEquals($name, $sut->name);
        $this->assertEquals($columns, $sut->columns);
        $this->assertEquals($otherParameters, $sut->otherParameters);
    }
}
