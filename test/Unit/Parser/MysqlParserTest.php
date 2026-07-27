<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\Parser;

use Override;
use Pongee\DatabaseSchemaVisualization\Parser\MysqlParser;
use Pongee\DatabaseSchemaVisualization\Parser\ParserInterface;

final class MysqlParserTest extends FullSchemaParserTestCase
{
    #[Override]
    protected static function fixturesSubDirectory(): string
    {
        return '/Mysql/';
    }

    #[Override]
    protected function createParser(): ParserInterface
    {
        return new MysqlParser();
    }
}
