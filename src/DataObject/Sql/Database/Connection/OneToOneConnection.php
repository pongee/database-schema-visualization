<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection;

class OneToOneConnection extends ConnectionAbstract
{
    #[\Override]
    public string $type {
        get => 'OneToOne';
    }
}
