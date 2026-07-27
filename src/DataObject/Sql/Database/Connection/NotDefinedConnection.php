<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection;

final class NotDefinedConnection extends ConnectionAbstract
{
    #[\Override]
    public string $type {
        get => '';
    }
}
