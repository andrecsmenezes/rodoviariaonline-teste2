<?php

namespace Api\Exceptions;

use League\Route\Http\Exception\NotFoundException;

class UserWrongPasswordException extends NotFoundException {
    private $username;

    public function __construct(string $username) {
        $this->username = $username;
        parent::__construct("Password wrong for user '{$username}'.");
    }

    public function getUsername(): string {
        return $this->username;
    }
}
