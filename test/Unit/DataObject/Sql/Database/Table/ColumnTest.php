<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\DataObject\Sql\Database\Table;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\ColumnInterface;

class ColumnTest extends TestCase
{
    public function getColumnsProvider(): array
    {
        return [
            ['member_id', 'INT', [10], 'UNSIGNED NOT NULL AUTO_INCREMENT', 'The member id'],
            ['type', 'VARCHAR', [64], 'NOT NULL', 'The type'],
            ['status', 'ENUM', ['enabled', 'deleted'], 'DEFAULT NULL', 'The status'],
        ];
    }

    /**
     * @dataProvider getColumnsProvider
     */
    public function testColumn(
        string $name,
        string $type,
        array $typeParameters,
        string $otherParameters,
        string $comment
    ): void {
        $sut = new Column($name, $type, $typeParameters, $otherParameters, $comment);

        $this->assertInstanceOf(ColumnInterface::class, $sut);

        $this->assertEquals($name, $sut->getName());
        $this->assertEquals($type, $sut->getType());
        $this->assertEquals($typeParameters, $sut->getTypeParameters());
        $this->assertEquals($otherParameters, $sut->getOtherParameters());
        $this->assertEquals($comment, $sut->getComment());
    }
}
