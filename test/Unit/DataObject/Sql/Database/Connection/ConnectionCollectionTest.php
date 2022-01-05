<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\DataObject\Sql\Database;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToOneConnection;

class ConnectionCollectionTest extends TestCase
{
    public function getCollectionProvider(): array
    {
        return [
            [
                new OneToManyConnection('log', 'member', ['member_id'], ['id']),
            ],
            [
                new OneToOneConnection('member_data', 'member', ['member_id'], ['id']),
            ],
            [
                new OneToManyConnection('log', 'member', ['member_id'], ['id']),
                new OneToOneConnection('member_data', 'member', ['member_id'], ['id']),
                new OneToOneConnection('member_account', 'member', ['member_id'], ['id']),
            ],
        ];
    }

    /**
     * @dataProvider getCollectionProvider
     */
    public function testCollection(ConnectionInterface ...$connections): void
    {
        $sut = new ConnectionCollection();

        foreach ($connections as $connection) {
            $sut->add($connection);
        }

        foreach ($sut as $item) {
            $this->assertInstanceOf(ConnectionInterface::class, $item);
        }

        $this->assertCount(count($connections), $sut->getIterator());
    }
}
