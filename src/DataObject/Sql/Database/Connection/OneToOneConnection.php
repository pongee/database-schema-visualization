<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection;

class OneToOneConnection extends ConnectionAbstract
{
    public function getType(): string
    {
        return 'OneToOne';
    }
}
