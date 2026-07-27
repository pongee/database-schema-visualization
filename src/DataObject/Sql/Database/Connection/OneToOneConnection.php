<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection;

readonly class OneToOneConnection extends ConnectionAbstract
{
    public function getType(): string
    {
        return 'OneToOne';
    }
}
