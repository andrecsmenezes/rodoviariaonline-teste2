<?php

namespace Api\Repositories;

use Api\Entities\User;
use Api\Contracts\UserRepositoryInterface;
use Api\Exceptions\UserNotFoundException;
use Api\Exceptions\UserWrongPasswordException;

class UserRepository extends Repository implements UserRepositoryInterface {
    /**
     * @throws UserNotFoundException
     * @throws UserWrongPasswordException
     */
    public function findByUsernameAndPassword(string $username, string $password): User {
        try {
            $this->connection->connect();

            $sql = "SELECT `id`, `email`, `password` FROM `users` WHERE `email` = :email";

            $smtp = $this->connection->prepare($sql);
            $smtp->bindParam(':email', $username);
            $smtp->execute();

            $data = $smtp->fetch(\PDO::FETCH_ASSOC);

            if(! $data) {
                throw new UserNotFoundException($username);
            }

            if(! password_verify($password, $data['password'])) {
                throw new UserWrongPasswordException($username);
            }

            return new User($data);
        } finally {
            $this->connection->disconnect();
        }
    }
}
