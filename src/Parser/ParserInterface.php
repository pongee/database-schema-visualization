<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Parser;

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\SchemaInterface;

interface ParserInterface
{
    public function run(string $sqls, ConnectionCollectionInterface $forcedConnectionCollection): SchemaInterface;
}
