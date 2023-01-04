<?php

namespace Api\Middlewares\Dto;

use HttpException;
use JsonException;
use League\Route\Http\Exception\BadRequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Api\Utils\EmailValidator;

class LoginDto implements MiddlewareInterface{
    /**
     * @throws JsonException
     * @throws BadRequestException
     * @throws HttpException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $errors = [];
        $data = $request->getParsedBody();

        if(! isset($data['username'])) {
            $errors['username'][] = 'username not found';
        }

        if(isset($data['username']) && ! EmailValidator::isEmail($data['username'])) {
            $errors['username'][] = 'username needs to be an email';
        }

        if(! isset($data['password'])) {
            $errors['password'][] = 'password not found';
        }

        if(count($errors) > 0) {
            throw new BadRequestException(json_encode($errors));
        }

        return $handler->handle($request);
    }
}
