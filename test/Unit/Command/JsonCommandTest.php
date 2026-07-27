<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\Command;

use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Pongee\DatabaseSchemaVisualization\Command\JsonCommand;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\NotDefinedConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;
use Pongee\DatabaseSchemaVisualization\Parser\MysqlParser;
use Pongee\DatabaseSchemaVisualization\Parser\ParserInterface;
use RuntimeException as RuntimeExceptionAlias;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class JsonCommandTest extends TestCase
{
    public function testName(): void
    {
        $this->assertNotEmpty($this->getCommand()->getName());
    }

    private function getCommand(string $rootDir = '', string $name = 'mysql:json'): JsonCommand
    {
        /** @var ParserInterface&Stub $parser */
        $parser = $this->createStub(ParserInterface::class);

        return new JsonCommand($parser, $rootDir, $name);
    }

    public function testDescription(): void
    {
        $this->assertNotEmpty($this->getCommand()->getDescription());
    }

    public function testSynopsis(): void
    {
        $this->assertEquals(
            'mysql:json [-c|--connection CONNECTION] [--] <file>',
            $this->getCommand()->getSynopsis()
        );
    }

    public function testCassandraSynopsis(): void
    {
        $this->assertEquals(
            'cassandra:json [-c|--connection CONNECTION] [--] <file>',
            $this->getCommand('', 'cassandra:json')->getSynopsis()
        );
    }

    public function testNoParameters(): void
    {
        $this->expectException(RuntimeExceptionAlias::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "file").');

        $parser = new MysqlParser();

        $command = new JsonCommand($parser, '', 'mysql:json');
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

        $parser = $this->createMock(ParserInterface::class);
        $parser
            ->expects($this->once())
            ->method('run')
            ->with(
                $fakeSqlContent,
                new ConnectionCollection()
                    ->add(new NotDefinedConnection('log', 'user', ['user_id'], ['user_id']))
            )
            ->willReturn(new Schema());

        $sut = new JsonCommand($parser, FIXTURES_DIRECTORY, 'mysql:json');
        $sut->run(
            new ArrayInput([
                'file' => $fakeSqlName,
                '--connection' => ['log.user_id=>user.user_id']
            ]),
            $output
        );

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'tables' => [],
                'connections' => []
            ]),
            $output->fetch()
        );
    }
}
