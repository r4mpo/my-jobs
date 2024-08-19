# Projeto "My Jobs" | Laravel, Vue.JS, MySQL, Tailwind

O projeto "My Jobs" consiste em uma "Plataforma para busca de vagas freelancers, empregos rápidos, comunicação ágil". Na prática, trata-se de mais um projeto presente em meu portfólio como programador full stack. Neste, em específico, priorizei fazer um estudo de ferramentas de desenvolvimento modernas, visando o padrão de microsserviços.

# Back-End

* PHP
* Laravel
* PHPUnit
* API
* Swagger

# Front-End

* Vue.JS
* HTML5
* CSS3
* TailwindCSS
* Vue-Router
* Axios

# Status

Atualmente o projeto está em desenvolvimento. A API está em estágio avançado, recebendo apenas correções pontuais. A aplicação do front-end está começando a ser desenvolvida, consumindo alguns endpoints como de login, por exemplo.

# API

## Perfis

### 1. Listar Perfis

**Endpoint:** `GET /api/profiles`

**Descrição:** Retorna uma lista de todos os perfis existentes no sistema.

**Segurança:** Requer autenticação com Bearer Token.

**Resposta de Sucesso (200 OK):**

```json
{
    "data": [
        {
            "id": 1,
            "name": "Moder",
            "guard_name": "api",
            "created_at": "2024-07-02T23:12:14.000000Z",
            "updated_at": "2024-07-02T23:12:14.000000Z"
        }
    ]
}
```

**Campos da Resposta:**

- `id`: Identificador único do perfil.
- `name`: Nome do perfil.
- `guard_name`: Nome do guard (proteção) associado ao perfil.
- `created_at`: Data e hora de criação do perfil.
- `updated_at`: Data e hora da última atualização do perfil.

---

### 2. Criar Novo Perfil

**Endpoint:** `POST /api/profiles`

**Descrição:** Cria um novo perfil com o nome e permissões especificados.

**Segurança:** Requer autenticação com Bearer Token.

**Corpo da Requisição:**

```json
{
    "name": "Editor",
    "permissions": [
        "api.vacancies.index",
        "api.vacancies.store",
        "api.vacancies.show"
    ]
}
```

**Campos do Corpo da Requisição:**

- `name`: Nome do novo perfil.
- `permissions`: Lista de permissões associadas ao perfil.

**Resposta de Sucesso (200 OK):**

```json
{
    "data": {
        "id": 1,
        "name": "Editor",
        "guard_name": "api",
        "created_at": "2024-07-02T23:12:14.000000Z",
        "updated_at": "2024-07-02T23:12:14.000000Z"
    }
}
```

**Tratamento de Erro:**

- Se o nome do perfil contiver "administrator" ou "default", será lançada uma exceção indicando que não é possível criar ou manipular perfis com esses nomes.

---

### 3. Atualizar Perfil

**Endpoint:** `PUT /api/profiles/{profile}`

**Descrição:** Atualiza um perfil existente pelo ID com um novo nome e permissões.

**Segurança:** Requer autenticação com Bearer Token.

**Parâmetros:**

- `profile` (caminho): ID do perfil a ser atualizado.

**Corpo da Requisição:**

```json
{
    "name": "Editor",
    "permissions": [
        "api.vacancies.index",
        "api.vacancies.store"
    ]
}
```

**Campos do Corpo da Requisição:**

- `name`: Novo nome do perfil.
- `permissions`: Lista de permissões atualizadas para o perfil.

**Resposta de Sucesso (200 OK):**

```json
{
    "data": {
        "id": 1,
        "name": "Editor",
        "guard_name": "api",
        "created_at": "2024-07-02T23:12:14.000000Z",
        "updated_at": "2024-07-02T23:12:14.000000Z"
    }
}
```

**Tratamento de Erro:**

- Se o nome do perfil contiver "administrator" ou "default", será lançada uma exceção indicando que não é possível atualizar perfis com esses nomes.

---

### 4. Excluir Perfil

**Endpoint:** `DELETE /api/profiles/{profile}`

**Descrição:** Exclui um perfil existente pelo ID.

**Segurança:** Requer autenticação com Bearer Token.

**Parâmetro:**

- `profile` (caminho): ID do perfil a ser excluído.

**Resposta de Sucesso (200 OK):**

```json
{
    "message": "Profile successfully deleted"
}
```

**Tratamento de Erro:**

- Se o nome do perfil contiver "administrator" ou "default", será lançada uma exceção indicando que não é possível excluir perfis com esses nomes.

---

### 5. Atribuir Perfil a Usuário

**Endpoint:** `GET /api/profiles/assign_role_for_user/{user_id}`

**Descrição:** Atribui um perfil a um usuário específico.

**Segurança:** Requer autenticação com Bearer Token.

**Parâmetros:**

- `user_id` (caminho): ID do usuário para quem o perfil será atribuído.
- `role_id` (consulta): ID do perfil a ser atribuído.

**Resposta de Sucesso (200 OK):**

```json
{
    "message": "Profile assign for user successfully"
}
```

**Tratamento de Erro:**

- Se ocorrer um erro ao atribuir o perfil, uma mensagem de erro será retornada com detalhes sobre o problema.

---

## Autenticação

### 1. Login

**Endpoint:** `POST /api/auth/login`

**Descrição:** Autentica um usuário e retorna um token JWT.

**Request:**

```json
{
  "email": "giovana@email.com",
  "password": "giovana3#_!.G"
}
```

**Resposta:**

```json
{
  "access_token": "token",
  "token_type": "bearer",
  "expires_in": 3600
}
```


### 2. Registro de Novo Usuário

**Endpoint:** `POST /api/auth/register`

**Descrição:** Cria um novo usuário na plataforma.

**Request:**

```json
{
  "name": "Giovana",
  "email": "giovana@email.com",
  "password": "giovana3#_!.G"
}
```

**Resposta:**

```json
{
  "user": { /* user data */ },
  "data": { /* input data */ },
  "message": "User registered successfully.",
  "success": true
}
```


### 3. Informações do Usuário

**Endpoint:** `POST /api/auth/me`

**Descrição:** Retorna as informações do usuário autenticado.

**Resposta:**

```json
{
  "id": 444,
  "name": "Giovana",
  "email": "giovana@gmail.com",
  "email_verified_at": null,
  "created_at": "2024-05-01T18:31:41.000000Z",
  "updated_at": "2024-05-01T18:31:41.000000Z"
}
```


### 4. Logout

**Endpoint:** `POST /api/auth/logout`

**Descrição:** Realiza o logout do usuário e invalida o token JWT.

**Resposta:**

```json
{
  "message": "Logout completed successfully."
}
```


### 5. Atualizar Token

**Endpoint:** `POST /api/auth/refresh`

**Descrição:** Restaura o token do usuário.

**Resposta:**

```json
{
  "access_token": "new_token",
  "token_type": "bearer",
  "expires_in": 3600
}
```

### 6. Informações do Usuário

1. **Obter Informações do Usuário**

   **Endpoint:** `GET /api/auth/infos/{user_id}`

   **Descrição:** Retorna todas as informações associadas a um usuário específico. Se `user_id` não for fornecido, retorna as informações do usuário autenticado.

   **Resposta:**

   ```json
   {
     "data": [
       {
         "id": 1,
         "info": "Formatted info content",
         "type": "phone"
       },
       // more infos
     ]
   }
   ```

---
