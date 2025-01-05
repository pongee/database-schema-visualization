<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\DataObject\Sql\Database\Table\Index;

use PHPUnit\Framework\TestCase;

abstract class NamedIndexAbstract extends TestCase
{
    public function getIndexProvider(): array
    {
        return [
            ['idx_member_id', ['member_id']],
            ['idx_member_id', ['member_id'], 'USING HASH'],
            ['idx_member_id_type', ['member_id', 'type']],
            ['idx_member_id_type', ['member_id', 'type'], 'USING HASH'],
            ['idx_member_id_type_system', ['member_id', 'type', 'system']],
        ];
    }
}
