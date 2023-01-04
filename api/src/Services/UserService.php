<?php

namespace Api\Services;

use Api\Contracts\UserRepositoryInterface;
use Api\Entities\User;

class UserService
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function login(string $username, string $password): User
    {
        return $this->repository->findByUsernameAndPassword($username, $password);
    }
}
