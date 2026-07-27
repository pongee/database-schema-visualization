<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\DataObject\Sql\Database\Connection;

use PHPUnit\Framework\Attributes\DataProvider;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToManyConnection;

class OneToManyConnectionTest extends ConnectionAbstract
{
    #[DataProvider('getConnectionProvider')]
    public function testData(
        string $childTablename,
        string $parentTableName,
        array $childTableColumns,
        array $parentTableColumns
    ): void {
        $oneToManyConnection = new OneToManyConnection(
            $childTablename,
            $parentTableName,
            $childTableColumns,
            $parentTableColumns
        );

        $this->assertEquals('OneToMany', $oneToManyConnection->type);
        $this->assertEquals($childTablename, $oneToManyConnection->childTableName);
        $this->assertEquals($parentTableName, $oneToManyConnection->parentTableName);
        $this->assertEquals($childTableColumns, $oneToManyConnection->childTableColumns);
        $this->assertEquals($parentTableColumns, $oneToManyConnection->parentTableColumns);
    }
}
