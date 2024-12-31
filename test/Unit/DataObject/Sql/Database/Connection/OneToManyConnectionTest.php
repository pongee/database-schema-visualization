<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\DataObject\Sql\Database\Connection;

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToManyConnection;

class OneToManyConnectionTest extends ConnectionAbstract
{
    /**
     * @dataProvider getConnectionProvider
     */
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

        $this->assertEquals('OneToMany', $oneToManyConnection->getType());
        $this->assertEquals($childTablename, $oneToManyConnection->getChildTableName());
        $this->assertEquals($parentTableName, $oneToManyConnection->getParentTableName());
        $this->assertEquals($childTableColumns, $oneToManyConnection->getChildTableColumns());
        $this->assertEquals($parentTableColumns, $oneToManyConnection->getParentTableColumns());
    }
}
