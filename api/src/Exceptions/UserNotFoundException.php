<?php

namespace Api\Exceptions;

use League\Route\Http\Exception\NotFoundException;

class UserNotFoundException extends NotFoundException {
    private $username;

    public function __construct(string $username) {
        $this->username = $username;
        parent::__construct("User '{$username}' not found.");
    }

    public function getUsername(): string {
        return $this->username;
    }
}
