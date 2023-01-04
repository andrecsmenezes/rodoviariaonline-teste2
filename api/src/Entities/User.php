<?php

namespace Api\Entities;

class User extends Entity {
    protected array $fillable = ['id', 'email'];
    protected array $hidden   = ['password'];

    public function setPassword(string $password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function checkPassword(string $password): bool {
        return password_verify($password, $this->password);
    }
}
