<?php

namespace Api\Contracts;

interface ConnectionInterface {
    public function connect(): void;
    public function disconnect(): void;
    public function prepare(string $sql): false|\PDOStatement;
}
