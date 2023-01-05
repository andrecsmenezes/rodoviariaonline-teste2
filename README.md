Olá!

Obrigado por essa oportunidade de participar do teste Rodoviária Online - Teste 2.

# Dados para a execução do teste:
Segunda etapa do processo seletivo:

Desenvolver uma aplicação de login e nos enviar com as instruções para validar
Prazo: 05/01/2023 até as 12:00
Enviar para o e-mail: a*********.d****z@r********ao****e.com.br
Em caso de dúvidas realizar a solicitação para o e-mail: a*********.d****z@r********ao****e.com.br

# Considerações
- A proposta do teste foi baseada em conversa com o orientador do teste no qual informou a necessidade de trabalhar em projeto legado com PHP, MySQL e jQuery
- Pensando nessa proposta o teste foi executado utilizando algumas poucas bibliotecas e foco em design pattern SOLID e Clean Code
- O projeto está dividido 3 partes separadas sendo:
  - API
  - APP
  - Banco de Dados

# Orientações para executar o projeto

Faça o clone do projeto para o seu computador:

```shell
git clone https://github.com/andrecsmenezes/rodoviariaonline-teste2.git
```

Entre na pasta raiz do projeto:

```shell
cd rodoviariaonline-teste2
```

Execute o seguinte comando:
```shell
docker compose up
```

# Acessos

## API

A url base para acesso a API é `http://localhost:8000`

| Endpoint | Método | Descrição                                                                                                                      |
|----------|--------|--------------------------------------------------------------------------------------------------------------------------------|
| /        | GET    | Recebe uma mensagem inicial caso esteja logado. Deve ser utilizado `Authentication Bearer` com o token gerado na rota `/login` |
| /login | POST | Recebe como parâmetro `username` e `password`, ambos do tipo `string` sendo o `username` o e-mail de acesso.                   |
| /migrate | GET | Faz a migração caso ainda não tenha sido realizada                                                                             |
| /migration-status | GET | Verifica se a migração já foi realizada                                                                                        |
| /status | GET | Verifica se a API está ativa                                                                                                   |

Neste repositório é possível encontrar o arquivo `./Rodoviaria Online.postman_collection.json` para instalação no Postman. Para que o mesmo funcione gere como variável de ambiente: `base_url -> http://localhost:8000`

## APP

A url do APP é `http://localhost`

- O APP foi construido com jQuery mas foi utilizado o conceito de SPA, dessa forma existe apenas um arquivo para controlar.
- Para acessar o login após fazer a migração basta usar o seguinte usuário:
  - *usuário*: **joaodasilva@gmail.com**
  - *senha*: **1234**

## Banco de Dados

O banco de dados pode ser acessado por:

| Parâmetro | Valor            |
|-----------|------------------|
| Host      | localhost        |
| User      | rodoviariaonline |
| Password  | rodoviariaonline |
| Database  | rodoviariaonline |

# Considerações finais

Caso ainda queira ver mais algum exemplo, realizei testes parecidos ao longo de minha carreira. Deixo abaixo alguns exemplos de testes realizados para apreciação.

- https://github.com/andrecsmenezes/desafio-entrevista-nodejs
- https://github.com/andrecsmenezes/teros-test-api
- https://github.com/andrecsmenezes/teros-test-app
- https://github.com/andrecsmenezes/desafio-monest

Mais uma vez agradeço a oportunidade e espero estar com vocês em breve!

Atenciosamente,

André Menezes