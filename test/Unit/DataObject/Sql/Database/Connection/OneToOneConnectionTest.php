<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\DataObject\Sql\Database\Connection;

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToOneConnection;

class OneToOneConnectionTest extends ConnectionAbstract
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
        $oneToOneConnection = new OneToOneConnection(
            $childTablename,
            $parentTableName,
            $childTableColumns,
            $parentTableColumns
        );

        $this->assertEquals('OneToOne', $oneToOneConnection->getType());
        $this->assertEquals($childTablename, $oneToOneConnection->getChildTableName());
        $this->assertEquals($parentTableName, $oneToOneConnection->getParentTableName());
        $this->assertEquals($childTableColumns, $oneToOneConnection->getChildTableColumns());
        $this->assertEquals($parentTableColumns, $oneToOneConnection->getParentTableColumns());
    }
}
