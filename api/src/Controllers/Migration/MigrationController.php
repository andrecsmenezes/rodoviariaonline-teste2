<?php

namespace Api\Controllers\Migration;

use League\Route\Http\Exception\BadRequestException;
use Psr\Http\Message\ServerRequestInterface;
use Api\Entities\User;
use Api\Exceptions\UserNotFoundException;
use Api\Exceptions\UserWrongPasswordException;

class MigrationController {
    private $connection;

    public function __construct(){
        global $connection;
        $this->connection = $connection;
    }

    public function migrationStatus(ServerRequestInterface $request): array {
        try {
            $this->connection->connect();

            $sql = "SELECT 1 from `users`";
            $smtp = $this->connection->prepare($sql);
            $smtp->execute();
            $smtp->getColumnMeta(0);
        } catch (\PDOException $error) {
            return [
                'OK'   => false,
                'version' => 1,
            ];
        } finally {
            $this->connection->disconnect();
        }

        return [
            'OK'   => true,
            'version' => 1,
        ];
    }

    public function migrate(ServerRequestInterface $request): array {
        try {
            $this->connection->connect();

            $sql = "CREATE TABLE users (
                        id       INT AUTO_INCREMENT PRIMARY KEY,
                        email    VARCHAR(255) NOT NULL,
                        password VARCHAR(255) NOT NULL
                    );";
            $smtp = $this->connection->prepare($sql);
            $smtp->execute();
            $smtp->getColumnMeta(0);

            $email    = 'joaodasilva@gmail.com';
            $password = password_hash('1234', PASSWORD_DEFAULT);

            $sql = "INSERT INTO `users` (`id`, `email`, `password`) VALUES (NULL, :email, :password);";
            $smtp = $this->connection->prepare($sql);
            $smtp->bindParam(':email',    $email);
            $smtp->bindParam(':password', $password);
            $smtp->execute();
            $smtp->getColumnMeta(0);
        } catch(\PDOException $error) {
            return [
                'OK'   => false,
                'version' => 1,
                'error_details' => $error
            ];
        } finally {
            $this->connection->disconnect();
        }

        return [
            'OK'   => true,
            'version' => 1,
        ];
    }
}
