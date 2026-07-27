<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\Parser;

use Override;
use Pongee\DatabaseSchemaVisualization\Parser\MariadbParser;
use Pongee\DatabaseSchemaVisualization\Parser\ParserInterface;

final class MariadbParserTest extends FullSchemaParserTestCase
{
    #[Override]
    protected static function fixturesSubDirectory(): string
    {
        return '/Mariadb/';
    }

    #[Override]
    protected function createParser(): ParserInterface
    {
        return new MariadbParser();
    }
}
