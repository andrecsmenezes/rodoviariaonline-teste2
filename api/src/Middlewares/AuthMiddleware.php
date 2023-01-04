<?php

namespace Api\Middlewares;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use League\Route\Http\Exception\UnauthorizedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @throws UnauthorizedException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $authHeader = $request->getHeaderLine('Authorization');

        if (empty($authHeader)) {
            throw new UnauthorizedException('Token not provided');
        }

        $token = trim(str_replace('Bearer', '', $authHeader));

        try {
            $payload = JWT::decode($token, (new Key($_ENV['JWT_KEY'], 'HS256')));
        } catch (Exception $e) {
            throw new UnauthorizedException('Invalid token');
        }

        $request = $request->withAttribute('user_id', $payload->id);
        return $handler->handle($request);
    }
}
