<?php

namespace Api\Repositories;

use Api\Providers\DbConnection;

class Repository {
    protected DbConnection $connection;

    public function __construct(DbConnection $connection) {
        $this->connection = $connection;
    }
}
