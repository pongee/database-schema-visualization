<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\DataObject\Sql\Database\Connection;

use PHPUnit\Framework\TestCase;

class ConnectionAbstract extends TestCase
{
    public function getConnectionProvider(): array
    {
        return [
            ['member_data', 'member', ['member_id'], ['id']],
            ['member_log', 'member', ['member_id'], ['member_id']],
        ];
    }
}
