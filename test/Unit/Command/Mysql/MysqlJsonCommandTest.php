<?php declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\Command\Mysql;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseSchemaVisualization\Command\Mysql\MysqlJsonCommand;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\NotDefinedConnection;
use Pongee\DatabaseSchemaVisualization\Parser\MysqlParser;
use RuntimeException as RuntimeExceptionAlias;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class MysqlJsonCommandTest extends TestCase
{
    public function testName(): void
    {
        $this->assertNotEmpty($this->getCommand()->getName());
    }

    private function getCommand(string $rootDir = ''): MysqlJsonCommand
    {
        /** @var MysqlParser $mysqlParser */
        $mysqlParser = $this->createMock(MysqlParser::class);

        return new MysqlJsonCommand($mysqlParser, $rootDir);
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

    public function testNoParameters(): void
    {
        $this->expectException(RuntimeExceptionAlias::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "file").');

        $parser = new MysqlParser();

        $command = new MysqlJsonCommand($parser, '');
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

        $parser = $this->createMock(MysqlParser::class);
        $parser
            ->expects($this->once())
            ->method('run')
            ->with(
                $fakeSqlContent,
                (new ConnectionCollection())
                    ->add(new NotDefinedConnection('log', 'user', ['user_id'], ['user_id']))
            );

        $sut = new MysqlJsonCommand($parser, FIXTURES_DIRECTORY);
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
