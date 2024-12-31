<?php

declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseSchemaVisualization\Export\Plantuml;
use Pongee\DatabaseSchemaVisualization\Parser\MysqlParser;

include __DIR__ . '/../../vendor/autoload.php';

$sqlSchema = '
  CREATE TABLE IF NOT EXISTS `foo` (
    `id` INT(10) UNSIGNED NOT NULL COMMENT "The id"
   ) ENGINE=innodb DEFAULT CHARSET=utf8;
';

$mysqlParser                = new MysqlParser();
$plantumlExport             = new Plantuml(file_get_contents(__DIR__ . '/../../src/Template/Plantuml/v1.twig'));
$forcedConnectionCollection = new ConnectionCollection();

$schema = $mysqlParser->run($sqlSchema, $forcedConnectionCollection);

print $plantumlExport->export($schema);
