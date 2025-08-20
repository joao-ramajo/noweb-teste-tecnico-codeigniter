# API REST - Code Igniter

Este projeto tem como objetivo o desenvolvimento de uma API REST para gerenciamento de notícias e validação de usuário.

O projeto conta com um CRUD completo para notícias nomeadas `articles` e o cadastro e login de usuário.

Desenvolvido utilizando o framework **Code Igniter 3**

# Sumário

- [Tecnologias](#tecnologias)
- [Instalação](#instalação)
  - [Clone do Repositório](#clone-o-repositório)
  - [Instalação de Dependências](#instale-as-dependências-e-gere-a-chave-de-acesso-do-laravel)
  - [Configuração do Banco de Dados](#configure-o-acesso-ao-banco-de-dados-em-env)
  - [Subindo o Docker](#suba-o-docker-compose)
  - [Rode as Migrations](#rode-as-migrations)
  - [Iniciando o Servidor](#inicie-o-servidor-do-projeto)
- [Fluxo do Usuário](#fluxo-do-usuário)
  - [Cadastro](#cadastro)
  - [Login](#login)
- [Fluxo das Notícias](#fluxo-das-notícias)
  - [Buscar Notícias](#buscar-notícias)
  - [Busca Única](#busca-única)
  - [Criar Notícia](#criar-notícia)
  - [Atualizar Notícias](#atualizar-notícias)
  - [Apagar Notícia](#apagar-notícia)
- [Tabela de Rotas](#tabela-de-rotas)
- [Testes](#testes)
  - [Como Rodar](#como-rodar-os-testes)
  - [O que será Testado](#o-que-será-testado)
- [Autenticação](#autenticação)
- [Autorização](#autorização)


## Tecnologias

- Code Igniter 3
- Docker
- MySQL
- Pest


## Instalação 

Para rodar este projeto você precisa das seguintes dependências:

- PHP ^7.4
- Docker ^28.3.3
- Composer ^2.8.10

### Clone o repositório

```bash
git clone https://github.com/joao-ramajo/noweb-teste-tecnico-codeigniter
cd noweb-teste-tecnico-codeigniter
```

### Instale as dependências e gere a chave de acesso do Laravel

```bash
composer install 
cp .env.example .env # copie as variavéis de ambiente
php artisan key:generate 
```

### Configure o acesso ao banco de dados em .env

```txt
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=api-noweb
DB_USERNAME=user
DB_PASSWORD=123456
```

### Suba o docker-compose 

```bash
docker compose up -d
```

### Rode as migrations
```
php artisan migrate
# ou rode com o seeder
php artisan migrate --seed
```
O seeder está configurado para gerar 20 notícias e um usuário com os acessos.

Email: admin@gmail.com
<br>
Senha: Aa123123

### Inicie o servidor do projeto

```
php artisan serve
```

Após isso a aplicação estará rodando em `http://localhost:8000/api`
## Fluxo do Usuário

### Cadastro

O usuário envia uma requisição `POST /users` para cadastrar suas informações e gerar um token de acesso.

Payload de cadastro.

```json
{
    "name" : "seu nome",
    "email" : "email@exemplo.com",
    "password" : "sua senha forte",
    "password_confirmation" : "repita a senha"
}
```

Após isso a requisição passa por uma validação utilizando a classe `UserStoreRequest.php` para fazer a validação de entrada de dados e garantir que todas as informações sejam enviadas corretamente.

Após isso, será retornado o payload contendo as informações do usuário e o ID registrado.

```json
{
    "message": "Usuário criado com sucesso",
    "data": {
        "name": "joao",
        "email": "joao@gmail.comd",
        "updated_at": "2025-08-19T16:45:44.000000Z",
        "created_at": "2025-08-19T16:45:44.000000Z",
        "id": 2
    }
}
```


### Login

Para realizar o login é enviado o `email`  e `password` da conta, a requisição é validada por `LoginRequest` para validar a entrada de dados.

A requisição deve ser enviada para `POST /api/login` gerida pelo `AuthController` para realizar as operações necessárias.

Após isso, dentro do controller a senha é verificada com o registro relacionado ao email enviado, se as informações estiverem corretas é devolvido um token de acesso no seguinte payload.

```json
{
    "token": "<token>"
}
```

Este token deve ser usado para as demais requisições do sistema para acessar recursos como a criação de notícias.

## Fluxo das Notícias

### Buscar Notícias

Para buscar informações sobre notícias deve ser enviado uma requisição `GET /api/articles` e no cabeçalho deve estar com o token de autorização.

Exemplo de requisição.

```bash
GET /api/articles
```

Headers obrigatórios.

```http
Authorization: Bearer <token>
Accept: application/json
```

A requisição se bem sucedida irá retornar um payload como este.

```json
{

    "data": [
    {
        "id": 1,
        "title": "Notícia do Dia",
        "content": "Contéudo da notícia",
        "author": "Alex Adams",
        "created_at": "2025-08-19T17:13:14.000000Z",
        "updated_at": "2025-08-19T17:13:14.000000Z"
    }
    ],
    "links": {
        "first": "http://localhost:8000/api/articles?page=1",
        "last": "http://localhost:8000/api/articles?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "page": null,
            "active": false
        },
        {
            "url": "http://localhost:8000/api/articles?page=1",
            "label": "1",
            "page": 1,
            "active": true
        },
        {
            "url": null,
            "label": "Next &raquo;",
            "page": null,
            "active": false
        }
    ],
    "path": "http://localhost:8000/api/articles",
    "per_page": 15,
    "to": 1,
    "total": 1
    }
}
```

### Busca Única

Para buscar uma notícia apenas, basta informar o ID na requisição.

Exemplo de requisição.

```bash
GET /api/articles/1
```

Headers obrigatórios.

```http
Authorization: Bearer <token>
Accept: application/json
```

O payload devolvido caso exista o registro. 

```json
{
    "data": {
        "id": 1,
        "title": "Notícia do Dia",
        "content": "Contéudo da notícia",
        "author": "Alex Adams",
        "created_at": "2025-08-19T17:13:14.000000Z",
        "updated_at": "2025-08-19T17:13:14.000000Z"
    }
}
```

### Criar notícia

Para criar uma nova notícia você deve enviar a requisição para `POST /api/articles` com o seguinte payload. 

```json
{
    "title" : "Título da notícia",
    "content" : "Contéudo da Notícia"
}
```

>Aviso: o cabeçalho deve conter o token de autorização como as requisições anteriores.

Após isso será registrado uma nova notícia no banco e irá retornar o seguinte payload.

```json
{
    "data": {
        "id": 1,
        "title": "Título da notícia",
        "content": "Contéudo da Notícia",
        "author": "Alex Adams",
        "created_at": "2025-08-19T17:21:42.000000Z",
        "updated_at": "2025-08-19T17:21:42.000000Z"
    },
    "message": "Notícia criada com sucesso."
}
```

### Atualizar Notícias

Para atualizar a notícia deve ser enviado como parametro da requisição o ID da notícia que deseja alterar.

Exemplo de requisição.

```bash
PUT /api/articles/1
```

Headers obrigatórios.

```http
Authorization: Bearer <token>
Accept: application/json
```

O payload para atualização deve ser.

```json
{
    "title" : "Novo Título da notícia",
    "content" : "Novo Contéudo da Notícia"
}
```

Caso aconteça tudo corretamente será devolvido o seguinte payload.

```json
{
    "message" : "Noticia atualizada com sucesso.",
    "data" : {
        "title" : {
            "id": 1,
            "title": "Novo Título da notícia",
            "content": "Novo Contéudo da Notícia",
            "author": "Alex Adams",
            "created_at": "2025-08-19T17:13:14.000000Z",
            "updated_at": "2025-08-19T17:41:42.000000Z"
        }
    }
}
```

### Apagar Notícia

Para apagar uma notícia você deve enviar uma requisição para `DELETE /api/articles/{id}` passando o ID da notícia.

Exemplo de requisição.

```bash
DELETE /api/articles/1
```

Headers obrigatórios.

```http
Authorization: Bearer <token>
Accept: application/json
```

Após isso a autorização será gerenciada por um Gate que irá verificar se o a requisição pode acontecer, caso sim o registro vai ser apagado do banco de dados e retornará o seguinte payload.

```json
{
    "message": "Noticia apagada com sucesso."
}
```


## Tabela de Rotas

| Método    | Endpoint           | Autorização | Descrição               | Payload / Retorno                                |
| --------- | ------------------ | ----------- | ----------------------- | ------------------------------------------------ |
| POST      | /users             | Não         | Cadastra usuário        | `{name, email, password, password_confirmation}` |
| POST      | /api/login         | Não         | Login e recebe token    | `{email, password}`                              |
| GET       | /api/articles      | Sim         | Lista todas as notícias | Retorna array de articles                        |
| GET       | /api/articles/{id} | Sim         | Busca uma notícia       | Retorna objeto article                           |
| POST      | /api/articles      | Sim         | Cria nova notícia       | `{title, content}`                               |
| PUT/PATCH | /api/articles/{id} | Sim         | Atualiza notícia        | `{title, content}`                               |
| DELETE    | /api/articles/{id} | Sim         | Deleta notícia          | Mensagem de sucesso                              |

## Testes

Os testes foram feitos de maneira a testar o fluxo completo da aplicação, por se tratar de lógicas simples e sem grande necessidade de diversas regras de negocio, optei por desenvolver testes de integração.

Para os requisitos do projeto adicionar camadas de complexidade maiores não faria sentido, assim causando um forte acoplamento com o Eloquent que já é testado pelo próprio Laravel, sendo assim optei por testes de integração para garantir que o fluxo está funcionando faz mais sentido do que diversos testes de unidade.

### Como rodar os testes

```
php artisan test
```


### O que será testado

- Cadastro de usuário
- Login e geração de token
- Criação, leitura, atualização e exclusão de notícias
- Restrições de acesso via autenticação

## Autenticação

A autenticação é feita pelo middleware disponibilizado pela biblioteca `Sanctum`utilizando tokens para verificação nas requisições.

## Autorização

A autorização para criação, edição e apagar notícias é feita atrâves de Policies configuradas em `ArticlePolicy.php`.