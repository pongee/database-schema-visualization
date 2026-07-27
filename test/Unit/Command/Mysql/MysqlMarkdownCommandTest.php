<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\Command\Mysql;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Pongee\DatabaseSchemaVisualization\Command\Mysql\MysqlMarkdownCommand;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\NotDefinedConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;
use Pongee\DatabaseSchemaVisualization\Parser\MysqlParser;
use RuntimeException as RuntimeExceptionAlias;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class MysqlMarkdownCommandTest extends TestCase
{
    public function testName(): void
    {
        $this->assertNotEmpty($this->getCommand()->getName());
    }

    private function getCommand(string $rootDir = ''): MysqlMarkdownCommand
    {
        /** @var MysqlParser&Stub $mysqlParser */
        $mysqlParser = $this->createStub(MysqlParser::class);

        return new MysqlMarkdownCommand($mysqlParser, $rootDir);
    }

    public function testDescription(): void
    {
        $this->assertNotEmpty($this->getCommand()->getDescription());
    }

    public function testSynopsis(): void
    {
        $this->assertEquals(
            'mysql:markdown [-c|--connection CONNECTION] [--] <file>',
            $this->getCommand()->getSynopsis()
        );
    }

    public function testRunWithNoParameters(): void
    {
        $this->expectException(RuntimeExceptionAlias::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "file").');

        $command = $this->getCommand();
        $command->run(
            new ArrayInput([]),
            new BufferedOutput()
        );
    }

    public function testCommand(): void
    {
        $fakeSqlName = 'fake.sql';
        $fakeSqlContent = file_get_contents(FIXTURES_DIRECTORY . $fakeSqlName);

        $output = new BufferedOutput();

        /** @var MysqlParser&MockObject $parser */
        $parser = $this->createMock(MysqlParser::class);
        $parser
            ->expects($this->once())
            ->method('run')
            ->with(
                $fakeSqlContent,
                new ConnectionCollection()
                    ->add(new NotDefinedConnection('log', 'user', ['user_id'], ['user_id']))
            )
            ->willReturn(new Schema());

        $sut = new MysqlMarkdownCommand($parser, FIXTURES_DIRECTORY);
        $sut->run(
            new ArrayInput([
                'file' => $fakeSqlName,
                '--connection' => ['log.user_id=>user.user_id'],
            ]),
            $output
        );

        $this->assertSame("# Schema\n", $output->fetch());
    }
}
