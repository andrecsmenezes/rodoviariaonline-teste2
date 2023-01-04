<?php

namespace Api\Providers;

use Api\Contracts\ConnectionInterface;

class DbConnection implements ConnectionInterface {
    private string    $host;
    private string    $user;
    private string    $password;
    private string    $database;
    private \PDO|null $pdo;

    public function __construct(array $config) {
        $this->host     = $config['host'];
        $this->user     = $config['user'];
        $this->password = $config['password'];
        $this->database = $config['database'];
    }

    public function connect(): void {
        $dsn       = "mysql:host={$this->host};dbname={$this->database}";
        $this->pdo = new \PDO($dsn, $this->user, $this->password);
    }

    public function disconnect(): void {
        $this->pdo = null;
    }

    public function prepare(string $sql): false|\PDOStatement
    {
        return $this->pdo->prepare($sql);
    }

    public function testConnection() {
        $this->connect();
        $this->disconnect();
    }
}
