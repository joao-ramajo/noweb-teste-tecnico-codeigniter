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


## Caso use linux

Em ambientes linux, o arquivo de inicialização é suportado basta rodar o comando:

```bash
composer project:init
```

Com isso ele irá automaticamente:

- Copiar arquivo de configurações de ambiente
- Instalar as dependências necessárias
- Montar o container
- Rodar o projeto

Após isso ele estará disponível em.
```http
http://localhost:8080
```
---

## Caso use outro sistema

### Clone o repositório

```bash
git clone https://github.com/joao-ramajo/noweb-teste-tecnico-codeigniter
cd noweb-teste-tecnico-codeigniter
```

### Configure o arquivo de variáveis de ambiente

```bash
cp .env.example .env
```

### Instale as dependências do Composer

```bash
composer install
```

### Monte e rode o container com Docker

```bash
docker compose up -d --build
```

Após isso ele estará disponível em.
```http
http://localhost:8080
```


## Fluxo do Usuário

### Cadastro

O usuário envia uma requisição `POST /users` para cadastrar suas informações.

Payload de cadastro.

```json
{
    "name" : "seu nome",
    "email" : "email@exemplo.com",
    "password" : "sua senha forte",
    "password_confirmation" : "repita a senha"
}
```

Após isso, será retornado o payload contendo as informações do usuário e o ID registrado.

```json
{
    "message": "Account created successfully",
    "data": {
        "id": "4",
        "name": "john",
        "email": "john@gmail.com",
        "created_at": "2025-08-20 17:46:49"
    }
}
```


### Login

Para realizar o login é enviado o `email`  e `password` da conta.

A requisição deve ser enviada para `POST /login` gerida pelo `AuthController` para realizar as operações necessárias.

Após isso, dentro do controller a senha é verificada com o registro relacionado ao email enviado, se as informações estiverem corretas é devolvido um token de acesso no seguinte payload.

```json
{
    "message": "Login successfully",
    "token": "<token>",
    "expiration": "2025-08-20 18:48:07"
}
```

Este token deve ser usado para as demais requisições do sistema para acessar recursos como a criação de notícias.

### Logout

Para realizar o logout basta enviar uma requisição `POST /logout` com o token no cabeçalho da requisição.

Exemplo de requisição.

```bash
POST /logout
```

Headers obrigatórios.

```http
Authorization: Bearer <token>
Accept: application/json
```

Após isso será retornado uma mensagem de sucesso e o token enviado será revogado.

## Fluxo das Notícias

### Buscar Notícias

Para buscar informações sobre notícias deve ser enviado uma requisição `GET /articles` e no cabeçalho deve estar com o token de autorização.

Exemplo de requisição.

```bash
GET /articles
```

Headers obrigatórios.

```http
Authorization: Bearer <token>
Accept: application/json
```

A requisição se bem sucedida irá retornar um payload como este.

```json
[
    {
        "page": 1,
        "total_pages": 0,
        "total": 0,
        "data": [<coleção de noticias>]
    }
]
```

### Busca Única

Para buscar uma notícia apenas, basta informar o ID na requisição.

Exemplo de requisição.

```bash
GET /articles?id=1
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
        "id": "2",
        "user_id": "4",
        "title": "<titulo da noticia>",
        "content": "<conteudo da noticia",
        "created_at": "2025-08-20 18:14:19"
    }
}
```

### Criar notícia

Para criar uma nova notícia você deve enviar a requisição para `POST /articles` com o seguinte payload.

```json
{
    "title" : "Título da notícia",
    "content" : "Conteúdo da Notícia"
}
```

>Aviso: o cabeçalho deve conter o token de autorização como as requisições anteriores.

Após isso será registrado uma nova notícia no banco e irá retornar o seguinte payload.

```json
{
    "message": "Article created successfully",
    "data": {
        "id": "1",
        "title": "Noticia do dia",
        "content": "Conteudo da noticia",
        "created_at": "2025-08-20 17:54:27"
    }
}
```

### Atualizar Notícias

Para atualizar a notícia deve ser enviado como parâmetro da requisição o ID da notícia que deseja alterar.

Como o Code Igniter 3 não tem um suporte nativo para operações PUT, PATCH e DELETE, optei por gerenciar através de um campo escondido da requisição `_method`.

Exemplo de requisição.

```bash
POST /articles/

BODY {
    "_method": "PUT"
    "title": "Novo titulo",
    "content": "Novo conteudo"
}
```

Headers obrigatórios.

```http
Authorization: Bearer <token>
Accept: application/json
```

Caso aconteça tudo corretamente será devolvido o seguinte payload.

```json
{
    "message": "Article updated successfully",
    "data": {
        "id": "1",
        "user_id": "4",
        "title": "Novo titulo",
        "content": "Novo conteudo",
        "created_at": "2025-08-20 17:54:27"
    }
}
```

### Apagar Notícia

Para apagar uma notícia você deve enviar uma requisição para `POST /articles` seguindo o mesmo padrão do `update`.

Exemplo de requisição.

```bash
POST /api/articles

BODY {
    "_method": "DELETE"
    "id": "<id da noticia>"
}
```

Headers obrigatórios.

```http
Authorization: Bearer <token>
Accept: application/json
```

Payload de retorno

```json
{
    "message": "Article deleted successfully"
}
```


## Tabela de Rotas

| Método    | Endpoint           | Autorização | Descrição               | Payload / Retorno                                |
| --------- | ------------------ | ----------- | ----------------------- | ------------------------------------------------ |
| POST      | /users             | Não         | Cadastra usuário        | `{message, data -> id, name, email, created_at}` |
| POST      | /login             | Não         | Login e recebe token    | `{message, token, expiration}`                              |
| GET       | /articles          | Sim         | Lista todas as notícias | Retorna array com paginação das notícias                        |
| GET       | /articles          | Sim         | Busca uma notícia       | Retorna objeto article                           |
| POST      | /articles          | Sim         | Cria nova notícia       | `{message, data -> id, title, content, creatd_at}`                               |
| PUT {_method:PUT}      | /articles          | Sim         | Atualiza notícia        | `{message, data -> id, user_id, title, content, creatd_at}`                               |
| DELETE {_method:DELETE}   | /articles          | Sim         | Deleta notícia          | Mensagem de sucesso                              |

## Autenticação

A autenticação é feita atrâves de tokens personalizados, ao fazer login será gerado um token para o usuário com expiração de 1 hora.

Sempre que o usuário fizer login e houver um token válido registrado ele será retornado, caso não existe ele irá gerar um novo.