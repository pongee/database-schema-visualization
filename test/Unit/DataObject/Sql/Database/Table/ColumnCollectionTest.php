<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\DataObject\Sql\Database\Table;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\ColumnCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\ColumnInterface;

class ColumnCollectionTest extends TestCase
{
    public function getColumnsProvider(): array
    {
        return [
            [
                new Column('member_id', 'INT', [10], 'NOT NULL', 'The member id'),
            ],
            [
                new Column('member_id', 'INT', [10], 'NOT NULL', 'The member id'),
                new Column('type', 'VARCHAR', [64], 'DEFAULT NULL', 'The type'),
            ],
            [
                new Column('member_id', 'INT', [10], 'NOT NULL', 'The member id'),
                new Column('type', 'VARCHAR', [64], 'NOT NULL', 'The type'),
                new Column('status', 'ENUM', ['enabled', 'deleted'], 'DEFAULT NUL', 'The status'),
            ],
        ];
    }

    /**
     * @dataProvider getColumnsProvider
     */
    public function testCollection(ColumnInterface ...$columns): void
    {
        $sut = new ColumnCollection();

        foreach ($columns as $column) {
            $sut->add($column);
        }

        foreach ($sut as $item) {
            $this->assertInstanceOf(ColumnInterface::class, $item);
        }

        $this->assertCount(count($columns), $sut->getIterator());
    }
}
