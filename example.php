<?php declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseSchemaVisualization\Export\Json;
use Pongee\DatabaseSchemaVisualization\Parser\MysqlParser;

include './vendor/autoload.php';

$sqlSchema = '
  CREATE TABLE IF NOT EXISTS `foo` (
    `id` INT(10) UNSIGNED NOT NULL COMMENT "The id"
   ) ENGINE=innodb DEFAULT CHARSET=utf8;
';

$mysqlParser                = new MysqlParser();
$jsonExport                 = new Json(); // or use new Plantuml();
$forcedConnectionCollection = new ConnectionCollection();

$schema = $mysqlParser->run($sqlSchema, $forcedConnectionCollection);

print $jsonExport->export($schema);
