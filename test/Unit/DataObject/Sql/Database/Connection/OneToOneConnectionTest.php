<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\DataObject\Sql\Database\Connection;

use PHPUnit\Framework\Attributes\DataProvider;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToOneConnection;

class OneToOneConnectionTest extends ConnectionAbstract
{
    #[DataProvider('getConnectionProvider')]
    public function testData(
        string $childTablename,
        string $parentTableName,
        array $childTableColumns,
        array $parentTableColumns
    ): void {
        $oneToOneConnection = new OneToOneConnection(
            $childTablename,
            $parentTableName,
            $childTableColumns,
            $parentTableColumns
        );

        $this->assertEquals('OneToOne', $oneToOneConnection->getType());
        $this->assertEquals($childTablename, $oneToOneConnection->childTableName);
        $this->assertEquals($parentTableName, $oneToOneConnection->parentTableName);
        $this->assertEquals($childTableColumns, $oneToOneConnection->childTableColumns);
        $this->assertEquals($parentTableColumns, $oneToOneConnection->parentTableColumns);
    }
}
