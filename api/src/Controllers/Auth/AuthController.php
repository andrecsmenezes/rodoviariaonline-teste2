<?php

namespace Api\Controllers\Auth;

use Firebase\JWT\JWT;
use Psr\Http\Message\ServerRequestInterface;
use Api\Repositories\UserRepository;
use Api\Services\UserService;

class AuthController {
    public function login(ServerRequestInterface $request): array {
         global $connection;

         extract($request->getParsedBody());

         $userRepository = new UserRepository($connection);
         $userService    = new UserService($userRepository);
         $user           = $userService->login($username, $password);
         $token          = JWT::encode($user->toArray(), $_ENV['JWT_KEY'], 'HS256');

         return array_merge($user->toArray(), ['token' => $token]);
    }

    public function logout(ServerRequestInterface $request): array {
        return [
            'title'   => 'Logout',
            'version' => 1,
        ];
    }
}
