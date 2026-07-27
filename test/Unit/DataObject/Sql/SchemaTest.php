<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\DataObject\Sql\Table\Database;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToOneConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\TableInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\SchemaInterface;

class SchemaTest extends TestCase
{
    public static function getTablesProvider(): array
    {
        return [
            [
                new Table('member'),
            ],
            [
                new Table('member'),
                new Table('member_data'),
                new Table('member_log'),
            ],
        ];
    }

    public static function getConnectionProvider(): array
    {
        return [
            [
                new OneToOneConnection('member_data', 'member', ['member_id'], ['id']),
            ],
            [
                new OneToOneConnection('member_data', 'member', ['member_id'], ['member_id']),
                new OneToManyConnection('member_log', 'member', ['member_id'], ['member_id']),
            ],
        ];
    }

    public function testInstanceOf(): void
    {
        $sut = new Schema();

        $this->assertInstanceOf(SchemaInterface::class, $sut);
    }

    #[DataProvider('getTablesProvider')]
    public function testTable(TableInterface ...$tables): void
    {
        $sut = new Schema();

        foreach ($tables as $table) {
            $sut->addTable($table);
        }

        foreach ($sut->tables as $table) {
            $this->assertTrue(in_array($table, $tables, true));
        }
    }

    #[DataProvider('getConnectionProvider')]
    public function testConnection(ConnectionInterface ...$connections): void
    {
        $sut = new Schema();

        foreach ($connections as $connection) {
            $sut->addConnection($connection);
        }

        foreach ($sut->connections as $connection) {
            $this->assertTrue(in_array($connection, $connections, true));
        }
    }
}
