# API REST - Code Igniter 3

Este projeto tem como objetivo o desenvolvimento de uma API REST para gerenciamento de notícias e validação de usuário.

O projeto conta com um CRUD completo para notícias e cadastro e autenticação de usuários.

# Tecnologias

- Code Igniter 3
- Docker
- MySQL
- Pest

## Fluxo do usuário

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