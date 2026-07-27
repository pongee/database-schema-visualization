<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\DataObject\Sql\Database\Table\Index;

use PHPUnit\Framework\Attributes\DataProvider;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\UniqueIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\UniqueIndexInterface;

class UniqueIndexTest extends NamedIndexAbstract
{
    public function testInstanceOf(): void
    {
        $sut = new UniqueIndex('idx_id', ['id']);

        $this->assertInstanceOf(UniqueIndexInterface::class, $sut);
    }

    #[DataProvider('getIndexProvider')]
    public function testIndex(string $name, array $columns, string $otherParameters = ''): void
    {
        $sut = new UniqueIndex($name, $columns, $otherParameters);

        $this->assertInstanceOf(UniqueIndexInterface::class, $sut);

        $this->assertEquals($name, $sut->name);
        $this->assertEquals($columns, $sut->columns);
        $this->assertEquals($otherParameters, $sut->otherParameters);
    }
}
