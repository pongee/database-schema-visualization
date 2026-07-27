# Database schema visualization

[![Latest Stable Version](https://img.shields.io/packagist/v/pongee/database-schema-visualization.svg)](https://packagist.org/packages/pongee/database-schema-visualization)
[![Minimum PHP Version](https://img.shields.io/packagist/php-v/pongee/database-schema-visualization)](https://php.net/)
[![License](https://img.shields.io/github/license/pongee/database-schema-visualization)](https://github.com/pongee/database-schema-visualization/blob/main/LICENSE)
![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/pongee/database-schema-visualization)

## Project goal
The aim of this project is to generate database documentation from sql schema.

## Supported databases
- MySQL
- MariaDB
- Apache Cassandra (Basics) 

## Supported Output formats
- PNG, SVG image
- Plantuml raw text
- Json
- Markdown

## Pre Installation
- https://graphviz.gitlab.io/download/

## Installation

```bash
$ composer require pongee/database-schema-visualization
or add it the your composer.json and make a composer update pongee/database-schema-visualization.
```
## Usage
### In console
#### PNG export
```bash
$  php ./database-schema-visualization mysql:image ./example/schema/sakila.sql > ./example/output/sakila/sakila.png
$  php ./database-schema-visualization mysql:image --type png ./example/schema/sakila.sql > ./example/output/sakila/sakila.png
```
Output:
![Example output](example/output/sakila/sakila.png?raw=true "Output")

#### SVG export
```bash
$  php ./database-schema-visualization mysql:image --type svg ./example/schema/sakila.sql > ./example/output/sakila/sakila.svg
```

#### Json export
```bash
$  php ./database-schema-visualization mysql:json ./example/schema/sakila.sql
```
#### Plantuml export
```bash
$  php ./database-schema-visualization mysql:plantuml ./example/schema/sakila.sql > ./example/output/sakila/sakila.puml
```
#### Markdown export
```bash
$  php ./database-schema-visualization mysql:markdown ./example/schema/sakila.sql > ./example/output/sakila/sakila.md
```

### PHP
#### Png export

```php
<?php declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseSchemaVisualization\Export\Plantuml;
use Pongee\DatabaseSchemaVisualization\Generator\ImageGenerator;
use Pongee\DatabaseSchemaVisualization\Parser\MysqlParser;

include __DIR__ . '/../../vendor/autoload.php';

$sqlSchema = '
  CREATE TABLE IF NOT EXISTS `foo` (
    `id` INT(10) UNSIGNED NOT NULL COMMENT "The id"
   ) ENGINE=innodb DEFAULT CHARSET=utf8;
';

$sqlParser                = new MysqlParser();
// $cqlParser                = new \Pongee\DatabaseSchemaVisualization\Parser\CassandraParser();
$plantumlExport             = new Plantuml(file_get_contents(__DIR__ . '/../../src/Template/Plantuml/v2.twig'));
$forcedConnectionCollection = new ConnectionCollection();
$imageGenerator             = new ImageGenerator(
    'png',
    __DIR__ . '/../../bin/plantuml-mit-1.2026.6.jar',
    __DIR__ . '/../../tmp/'
);

$schema = $sqlParser->run($sqlSchema, $forcedConnectionCollection);

print $imageGenerator->generate($plantumlExport->export($schema));
```
#### Json export
```php
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
$jsonExport                 = new Json();
$forcedConnectionCollection = new ConnectionCollection();

$schema = $mysqlParser->run($sqlSchema, $forcedConnectionCollection);

print $jsonExport->export($schema);
```

<details>
  <summary>This will generate:</summary>
  <div>
    <pre>
{
    "tables": {
        "foo": {
            "columns": [
                {
                    "name": "id",
                    "type": "INT",
                    "typeParameters": [
                        "10"
                    ],
                    "otherParameters": "UNSIGNED NOT NULL",
                    "comment": "The id"
                }
            ],
            "indexs": {
                "simple": [],
                "spatial": [],
                "fulltext": [],
                "unique": []
            },
            "primaryKey": []
        }
    },
    "connections": []
}
    </pre>
   </div>
</details>

#### Markdown export
```php
<?php declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseSchemaVisualization\Export\Markdown;
use Pongee\DatabaseSchemaVisualization\Parser\MysqlParser;

include './vendor/autoload.php';

$sqlSchema = '
  CREATE TABLE IF NOT EXISTS `foo` (
    `id` INT(10) UNSIGNED NOT NULL COMMENT \'The id\'
   ) ENGINE=innodb DEFAULT CHARSET=utf8;
';

$mysqlParser                = new MysqlParser();
$markdownExport             = new Markdown(file_get_contents('./src/Template/Markdown/v1.twig'));
$forcedConnectionCollection = new ConnectionCollection();

$schema = $mysqlParser->run($sqlSchema, $forcedConnectionCollection);

print $markdownExport->export($schema);
```

<details>
  <summary>This will generate:</summary>
  <div>

# Schema

## `foo` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| id | INT ( 10 ) | UNSIGNED NOT NULL | The id |

  </div>
</details>
