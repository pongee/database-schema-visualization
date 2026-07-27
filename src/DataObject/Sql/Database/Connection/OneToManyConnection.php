<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection;

use Override;

final class OneToManyConnection extends ConnectionAbstract
{
    #[Override]
    public string $type {
        get => 'OneToMany';
    }
}
