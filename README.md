# Database schema visualization

[![Latest Stable Version](https://img.shields.io/packagist/v/pongee/database-schema-visualization.svg)](https://packagist.org/packages/pongee/database-schema-visualization)
[![Minimum PHP Version](https://img.shields.io/packagist/php-v/pongee/database-schema-visualization)](https://php.net/)

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

## Installation

```bash
$ composer require pongee/database-schema-visualization
```
## Commands
Every command reads a schema file and writes the result to **stdout**, so redirect it into a file. Foreign keys are resolved automatically from the schema.

Each command exists for both MySQL (`mysql:`) and Apache Cassandra (`cassandra:`):

| Command | Output |
| --- | --- |
| `mysql:json` / `cassandra:json` | JSON |
| `mysql:plantuml` / `cassandra:plantuml` | PlantUML raw text |
| `mysql:markdown` / `cassandra:markdown` | Markdown |
| `mysql:image` / `cassandra:image` | PNG / SVG image |

Argument and options:

| Name | Description |
| --- | --- |
| `file` | Path to the schema file. **Required.** |
| `--type` | Image format for the `image` commands: `png` (default) or `svg`. |
| `--template` | Twig template used for rendering. Defaults to the bundled v2 template. |

## Usage
The command, argument and options are the same across every run mode below — see [Commands](#commands) for the full list.

### Command line

```bash
$ php ./database-schema-visualization <command> [options] <file> > output
```

For example:

```bash
$ php ./database-schema-visualization mysql:image --type png ./example/schema/sakila.sql > ./example/output/sakila/sakila.png
```

Output:
![Example output](example/output/sakila/sakila.png?raw=true "Output")

### Docker
The image is published to the GitHub Container Registry, built for both `linux/amd64` and `linux/arm64`.

```bash
$ docker pull ghcr.io/pongee/database-schema-visualization:latest
```

Mount your schema into the container and pass the same command and options as on the CLI:

```bash
$ docker run --rm -v "$PWD/schema.sql:/app/schema.sql" \
    ghcr.io/pongee/database-schema-visualization mysql:image --type png schema.sql > diagram.png
```

List the available commands:

```bash
$ docker run --rm ghcr.io/pongee/database-schema-visualization list
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
