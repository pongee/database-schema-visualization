<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\Test\Unit\Parser;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\ConnectionCollectionInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\TableInterface;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\SchemaInterface;
use Pongee\DatabaseSchemaVisualization\Parser\CassandraParser;
use RecursiveIteratorIterator;
use SplFileInfo;

class CassandraParserTest extends TestCase
{
    public static function getSchemaProvider(): array
    {
        $directoryIterator = new RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(FIXTURES_DIRECTORY . '/Cassandra/')
        );

        $providers = [];
        $directoryIterator->rewind();
        foreach ($directoryIterator as $file) {
            /** @var SplFileInfo $file */
            if ($file->isFile() && $file->getExtension() === 'sql') {
                $forcedConnections = new ConnectionCollection();
                $expendedSchemaPath = dirname($file->getRealPath()) . '/expectedSchema.php';
                $schemaObject = include $expendedSchemaPath;

                if (!$schemaObject instanceof SchemaInterface) {
                    throw new \InvalidArgumentException(
                        sprintf(
                            '%s file is not a SchemaInterface',
                            $expendedSchemaPath
                        )
                    );
                }

                $forcedConnectionsPath = dirname($file->getRealPath()) . '/forcedConnection.php';
                if (is_readable($forcedConnectionsPath)) {
                    $forcedConnections = include $forcedConnectionsPath;

                    if (!$forcedConnections instanceof ConnectionCollectionInterface) {
                        throw new \InvalidArgumentException(
                            sprintf(
                                '%s file is not a ConnectionCollectionInterface',
                                $forcedConnections
                            )
                        );
                    }
                }

                $providers[] = [$file, $schemaObject, $forcedConnections];
            }
        }

        return $providers;
    }

    #[DataProvider('getSchemaProvider')]
    public function testParser(
        SplFileInfo $file,
        SchemaInterface $schemaObject,
        ConnectionCollectionInterface $forcedConnections
    ): void {
        $sut = new CassandraParser();
        $result = $sut->run(file_get_contents($file->getRealPath()), $forcedConnections); //@todo

        foreach ($result->tables as $table) {
            $expectedTable = $schemaObject->tables->offsetGet($table->name);

            $this->assertInstanceOf(
                TableInterface::class,
                $expectedTable,
                sprintf('Bad table. Schema: %s, table: %s', $file->getRealPath(), $table->name)
            );

            foreach ($table->columns as $columnName => $column) {
                $this->assertEquals(
                    $expectedTable->columns->offsetGet($columnName),
                    $column,
                    sprintf(
                        "Bad column.\n Schema: %s \nTable: %s \nColumn: %s",
                        $file->getRealPath(),
                        $table->name,
                        $columnName
                    )
                );
            }

            $this->assertEquals(
                $expectedTable->simpleIndexes,
                $table->simpleIndexes,
                sprintf("Bad simple indexes. \nSchema: %s \nTable: %s", $file->getRealPath(), $table->name)
            );

            $this->assertEquals(
                $expectedTable->uniqueIndexes,
                $table->uniqueIndexes,
                sprintf("Bad unique indexes. \nSchema: %s \nTable: %s", $file->getRealPath(), $table->name)
            );

            $this->assertEquals(
                $expectedTable->fulltextIndexes,
                $table->fulltextIndexes,
                sprintf("Bad fulltext indexes. \nSchema: %s \nTable: %s", $file->getRealPath(), $table->name)
            );

            $this->assertEquals(
                $expectedTable->spatialIndexes,
                $table->spatialIndexes,
                sprintf("Bad spatial indexes. \nSchema: %s \ntable: %s", $file->getRealPath(), $table->name)
            );

            $this->assertEquals(
                $expectedTable->primaryKey,
                $table->primaryKey,
                sprintf("Bad primary key. \nSchema: %s \nTable: %s", $file->getRealPath(), $table->name)
            );
        }

        $this->assertEquals(
            $schemaObject->connections,
            $result->connections,
            sprintf('Schema %s', $file->getRealPath())
        );

        // Double checking
        $this->assertEquals($schemaObject, $result, sprintf('Schema %s', $file->getRealPath()));
    }
}
