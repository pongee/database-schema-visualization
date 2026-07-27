<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\Command;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Pongee\DatabaseSchemaVisualization\Command\PlantumlCommand;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\NotDefinedConnection;
use Pongee\DatabaseSchemaVisualization\Parser\ParserInterface;
use RuntimeException as RuntimeExceptionAlias;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class PlantumlCommandTest extends TestCase
{
    public function testName(): void
    {
        $this->assertNotEmpty($this->getCommand()->getName());
    }

    private function getCommand(string $rootDir = '', string $name = 'mysql:plantuml'): PlantumlCommand
    {
        /** @var ParserInterface&Stub $parser */
        $parser = $this->createStub(ParserInterface::class);

        return new PlantumlCommand($parser, $rootDir, $name);
    }

    public function testDescription(): void
    {
        $this->assertNotEmpty($this->getCommand()->getDescription());
    }

    public function testSynopsis(): void
    {
        $this->assertEquals(
            'mysql:plantuml [-t|--template [TEMPLATE]] [-c|--connection CONNECTION] [--] <file>',
            $this->getCommand()->getSynopsis()
        );
    }

    public function testCassandraSynopsis(): void
    {
        $this->assertEquals(
            'cassandra:plantuml [-t|--template [TEMPLATE]] [-c|--connection CONNECTION] [--] <file>',
            $this->getCommand('', 'cassandra:plantuml')->getSynopsis()
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

    public function testRunWithBadSqlPath(): void
    {
        $this->expectException(RuntimeExceptionAlias::class);
        $this->expectExceptionMessage('Bad sql file path.');

        $command = $this->getCommand(FIXTURES_DIRECTORY);
        $command->run(
            new ArrayInput([
                'file' => 'badSqlFile.sql'
            ]),
            new BufferedOutput()
        );
    }

    public function testRunWithBadTemplatePath(): void
    {
        $this->expectException(RuntimeExceptionAlias::class);
        $this->expectExceptionMessage('Bad template file path.');

        $command = $this->getCommand(FIXTURES_DIRECTORY);
        $command->run(
            new ArrayInput([
                'file' => 'fake.sql',
                '--template' => 'badTemplateFile.twig',
            ]),
            new BufferedOutput()
        );
    }

    public function testRunWithAllParameters(): void
    {
        $fakeSqlName = 'fake.sql';
        $fakeSqlContent = file_get_contents(FIXTURES_DIRECTORY . $fakeSqlName);
        $fakeTemplateName = 'fake.twig';
        $fakeTemplateContent = file_get_contents(FIXTURES_DIRECTORY . 'fake.twig');

        $output = new BufferedOutput();

        /** @var ParserInterface&MockObject $parser */
        $parser = $this->createMock(ParserInterface::class);
        $parser
            ->expects($this->once())
            ->method('run')
            ->with(
                $fakeSqlContent,
                new ConnectionCollection()
                    ->add(new NotDefinedConnection('log', 'user', ['user_id'], ['user_id']))
            );

        $sut = new PlantumlCommand($parser, FIXTURES_DIRECTORY, 'mysql:plantuml');
        $sut->run(
            new ArrayInput([
                'file' => $fakeSqlName,
                '--template' => $fakeTemplateName,
                '--connection' => ['log.user_id=>user.user_id'],
            ]),
            $output
        );

        $this->assertEquals($fakeTemplateContent, $output->fetch());
    }
}
