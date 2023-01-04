<?php

namespace Api\Contracts;

interface UserRepositoryInterface extends RepositoryInterface {
    public function findByUsernameAndPassword(string $username, string $password);
}
