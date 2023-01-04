<?php

namespace Api\Controllers\Hello;

use Psr\Http\Message\ServerRequestInterface;

class HelloController {
    public function index(ServerRequestInterface $request): array {
        return [
            'title'   => 'Rodoviária Online API',
            'message' => 'Olá! Estamos felizes em ver que o seu token de acesso está funcionando e agora você pode acessar todas as rotas que precisam de autorização. Esperamos que você aproveite todos os recursos disponíveis através da nossa API e não hesite em entrar em contato conosco se precisar de qualquer ajuda ou tiver alguma dúvida. Aproveite sua experiência com a nossa API!',
            'version' => 1,
        ];
    }

    public function status(ServerRequestInterface $request): array {
        return [
            'OK'   => true,
            'version' => 1,
        ];
    }
}
