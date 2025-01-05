<?php

declare(strict_types=1);

namespace Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection;

class ConnectionCollection implements ConnectionCollectionInterface
{
    /** @var ConnectionInterface[] */
    private array $connections = [];

    public function adds(ConnectionInterface ...$connections): self
    {
        foreach ($connections as $connection) {
            $this->add($connection);
        }

        return $this;
    }

    public function add(ConnectionInterface $connection): self
    {
        $this->connections[] = $connection;

        return $this;
    }

    public function getIterator(): ConnectionIterator
    {
        return new ConnectionIterator($this->connections);
    }

    public function jsonSerialize(): array
    {
        return $this->connections;
    }
}
