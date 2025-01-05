<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Export;

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\SchemaInterface;

interface ExportInterface
{
    public function export(SchemaInterface $schema): string;
}
