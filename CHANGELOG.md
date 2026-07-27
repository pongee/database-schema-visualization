# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [5.0.0] - 2026-07-27
### Added
- Markdown export (`mysql:markdown` command and `Export\Markdown`) listing tables, columns, keys, indexes and connections, driven by a customizable Twig template (`src/Template/Markdown/v1.twig`)
- MySQL column types: NUMERIC, REAL, DEC, FIXED, SERIAL, VECTOR and the INT1-INT8/MIDDLEINT aliases
- Inline PRIMARY KEY and inline (column-level) FOREIGN KEY parsing
- Anonymous FOREIGN KEY (without a CONSTRAINT name) parsing
- MySQL employees, world_x and airportdb sample databases as full-database test fixtures
- Rewrite the PlantUML template to use the current preprocessor (`!function`/`!procedure`/`!foreach`), replacing the legacy `!definelong` template
- Apache Cassandra CLI commands (`cassandra:json`, `cassandra:plantuml`, `cassandra:markdown`, `cassandra:image`)
- Dedicated `MariadbParser` that adds the MariaDB-specific column types `UUID`, `INET4` and `INET6` on top of the MySQL parser (the column type list is now overridable)
- MariaDB `CREATE OR REPLACE TABLE` statements are now recognized (normalized to `CREATE TABLE` in the MariaDB parser)
- Docker image published to the GitHub Container Registry, built natively for linux/amd64 and linux/arm64

### Removed
- The `--connection` command option and the option shortcuts (`-c`, `-t`, `-it`)

### Fixed
- `UNIQUE`, `FULLTEXT` and `SPATIAL` index definitions written without the `KEY`/`INDEX` keyword (e.g. `UNIQUE (email)`, `FULLTEXT(description)`) were dropped
- Column `COMMENT` escapes (`''` and `\'`) are now unescaped instead of kept raw
- `ENUM`/`SET` values containing a comma (e.g. `enum('on,hold','closed')`) were split into separate values
- GEOMETRYCOLLECTION type was never recognized (typo in the type list)
- Index columns with a prefix length or ASC/DESC direction, and composite indexes mixing them
- Backtick-quoted table names containing spaces
- Whitespace robustness for UNIQUE/FULLTEXT/SPATIAL keys and REFERENCES clauses
- Generated-column (GENERATED ALWAYS AS ...) definitions no longer leak into column parameters
- CLI entry point broke on Symfony Console 8 (`Application::add()` removed) — use `addCommand()`

### Changed
- Switch to PHP 8.5
- Update dependencies to latest majors (symfony/console 7-8, PHPUnit 13, PHP_CodeSniffer 4)
- Upgrade the bundled PlantUML jar to the MIT build (plantuml-mit-1.2026.6)
- Expose DataObjects (Column, Index, Table, Schema, Connection) via readonly / property-hook properties instead of getters
- Validate the image `--type` option with an `ImageType` enum
- Group generated example outputs per database under `example/output/<db>/`
- Replace the per-database command classes (`Command\Mysql\*`) with database-agnostic, reusable command classes under `Command\` whose command name is passed in the constructor

## [4.0.0] - 2024-01-04
### Changed
- Switch to PHP 8.1

## [3.2.0] - 2022-03-05
### Added
- Base Apache Cassandra support

## [3.1.2] - 2022-02-14
### Fixed
- Fix failed tests

## [3.1.0] - 2022-02-14
### Added
- Support symfony/console 4, and 5 as well

## [3.0.0] - 2022-01-06
### Changed
- Support only PHP 8

## [2.0.0] - 2022-01-05
### Changed
- PHP 8 support & increase the minimum php version to PHP 7.4

## [1.0.2] - 2022-01-05
### Fixed
- Setup phpstan

## [1.0.1] - 2022-01-05
### Fixed
- Fix PSR12 problems

## [1.0.0] - 2022-01-05
### Fixed
- Init repository
