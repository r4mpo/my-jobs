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

## Instalação + Testes Unitários + Validações

- Dentro do diretório da api, no readme do projeto Laravel encontra-se um manual de instação e de testes unitários;
- Os testes unitários são feitos com PHPUnit;
- As validações são feitas por meio dos form_requests, visando a clareza dos códigos dos controllers.

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

## Gerenciamento de Informações

### 1. Criar Informação

**Endpoint:** `POST /api/infos`

**Descrição:** Cria uma nova informação associada a um usuário.

**Request:**

```json
{
  "code": "1",
  "info": "14920388",
  "user_id": 1
}
```

**Resposta:**

```json
{
  "data": {
    "id": 8,
    "code": "1",
    "info": "14920388",
    "user_id": 1,
    "updated_at": "2024-06-24T22:24:25.000000Z",
    "created_at": "2024-06-24T22:24:25.000000Z"
  }
}
```

### 2. Atualizar Informação

**Endpoint:** `PUT /api/infos/{id}`

**Descrição:** Atualiza uma informação existente com os dados fornecidos.

**Request:**

```json
{
  "code": "3",
  "info": "Updated information content.",
  "user_id": 1
}
```

**Resposta:**

```json
{
  "data": {
    "id": 8,
    "code": "3",
    "info": "Updated information content.",
    "user_id": 1,
    "updated_at": "2024-06-24T22:30:45.000000Z",
    "created_at": "2024-06-24T22:24:25.000000Z"
  }
}
```

**Erro 400:** Informação inválida ou não autorizada.

```json
{
  "message": "Invalid info: unauthorized"
}
```


### 3. Excluir Informação

**Endpoint:** `DELETE /api/infos/{id}`

**Descrição:** Remove uma informação existente. **Nota:** Este endpoint está desativado e lançará um erro se acessado.

**Erro:**

```json
{
  "message": "invalid route"
}
```

### 4. Observações Gerais

- Todos os endpoints relacionados ao gerenciamento de informações exigem autenticação via JWT.
- Erros genéricos, como problemas internos do servidor, retornam mensagens de erro e códigos apropriados para facilitar o diagnóstico.

---


Claro! Aqui está a documentação completa para todos os endpoints da API "Vacancies":

---

## Vagas

### 1. Listar Vagas

**Endpoint:** `GET /api/vacancies`

**Descrição:** Retorna uma lista de todas as vagas disponíveis. É possível aplicar filtros para refinar a busca.

**Parâmetros de Consulta:**

- `zip_code` (string, opcional): Filtra as vagas pelo código postal.
- `wage` (string, opcional): Filtra as vagas pelo salário.
- `short_description` (string, opcional): Filtra as vagas pela descrição curta.
- `long_description` (string, opcional): Filtra as vagas pela descrição longa.
- `amount_page` (integer, opcional, padrão=10): Número de vagas por página.

**Exemplo de Resposta:**

```json
Aqui está a documentação em markdown para o endpoint `my_published_vacancies`:

---

# API "Vacancies" - Endpoints para Usuários

## Endpoint: Listar Vagas Publicadas pelo Usuário

**Endpoint:** `GET /api/vacancies_user/my_published_vacancies`

**Descrição:** Retorna uma lista de vagas publicadas pelo usuário autenticado.

**Autenticação:** Bearer Token (necessário para acessar este endpoint).

### Resposta de Sucesso

**Código de Status:** `200 OK`

**Descrição:** Retorna uma lista de vagas publicadas pelo usuário autenticado.

**Formato da Resposta:**

```json
{
  "data": [
    {
      "id": 2,
      "created_at": "2024-05-26T22:40:21.000000Z",
      "updated_at": "2024-05-26T22:40:21.000000Z",
      "short_description": "test update",
      "long_description": "Fazendo teste de tal tal tal.",
      "wage": "R$ 7,77",
      "zip_code": "12345678",
      "user": {
        "id": 1,
        "name": "Erick",
        "email": "erick@jobs.com",
        "email_verified_at": "erick_verify@jobs.com",
        "created_at": "2024-06-04T01:42:02.000000Z",
        "updated_at": "2024-06-04T01:42:02.000000Z"
      }
    }
  ]
}
```

### Campos da Resposta

- **data**: Array contendo uma lista de vagas publicadas pelo usuário.
  - **id**: ID da vaga (inteiro).
  - **created_at**: Data e hora de criação da vaga (string, formato ISO 8601).
  - **updated_at**: Data e hora da última atualização da vaga (string, formato ISO 8601).
  - **short_description**: Descrição curta da vaga (string).
  - **long_description**: Descrição longa da vaga (string).
  - **wage**: Salário da vaga formatado (string).
  - **zip_code**: Código postal (CEP) da vaga (string).
  - **user**: Objeto contendo informações do usuário que publicou a vaga.
    - **id**: ID do usuário (inteiro).
    - **name**: Nome do usuário (string).
    - **email**: Email do usuário (string).
    - **email_verified_at**: Email verificado do usuário (string).
    - **created_at**: Data e hora de criação do usuário (string, formato ISO 8601).
    - **updated_at**: Data e hora da última atualização do usuário (string, formato ISO 8601).

### Exemplo de Requisição

```http
GET /api/vacancies_user/my_published_vacancies
Authorization: Bearer <your_access_token>
```

---

Esta documentação fornece uma visão clara sobre como acessar e utilizar o endpoint para listar as vagas publicadas pelo usuário autenticado. Caso precise de mais informações ou de um ajuste na documentação, por favor, me avise!{
  "data": [
    {
      "id": 1,
      "short_description": "Desenvolvedor Backend",
      "long_description": "Vaga para desenvolvedor backend com experiência em Node.js.",
      "wage": "R$ 12409,14",
      "zip_code": "14148-300",
      "user_id": 5,
      "user": "Erick Rampo"
    }
  ],
  "pages": {
    "amount": "10",
    "current": "1"
  }
}

```

```

### 2. Criar Nova Vaga

**Endpoint:** `POST /api/vacancies`

**Descrição:** Cria uma nova vaga de emprego com as informações fornecidas.

**Corpo da Requisição:**

- `short_description` (string, obrigatório): Descrição curta da vaga (entre 5 e 60 caracteres).
- `long_description` (string, obrigatório): Descrição longa da vaga (entre 10 e 250 caracteres).
- `wage` (integer, obrigatório): Salário da vaga (em centavos).
- `zip_code` (string, obrigatório): Código postal (CEP) da vaga.

**Exemplo de Requisição:**

```json
{
  "short_description": "Desenvolvedor Frontend",
  "long_description": "Vaga para desenvolvedor frontend com experiência em React.",
  "wage": 1240914,
  "zip_code": "14315-250"
}
```

**Exemplo de Resposta:**

```json
{
  "data": {
    "id": 8,
    "short_description": "Desenvolvedor Frontend",
    "long_description": "Vaga para desenvolvedor frontend com experiência em React.",
    "wage": "1240914",
    "zip_code": "14315-250",
    "user_id": 5,
    "updated_at": "2024-05-17T00:00:00Z"
  }
}
```

### 3. Consultar Detalhes da Vaga

**Endpoint:** `GET /api/vacancies/{id}`

**Descrição:** Retorna os detalhes de uma vaga específica pelo ID.

**Exemplo de Resposta:**

```json
{
  "data": {
    "id": 1,
    "short_description": "Desenvolvedor Backend",
    "long_description": "Vaga para desenvolvedor backend com experiência em Node.js.",
    "wage": "1240914",
    "zip_code": "14148-300",
    "user_id": 5,
    "user": "Erick Rampo",
    "updated_at": "2024-05-17T00:00:00Z"
  }
}
```

### 4. Atualizar Vaga

**Endpoint:** `PUT /api/vacancies/{id}`

**Descrição:** Atualiza uma vaga existente pelo ID com novas informações.

**Corpo da Requisição:**

- `short_description` (string, opcional): Nova descrição curta da vaga.
- `long_description` (string, opcional): Nova descrição longa da vaga.
- `wage` (integer, opcional): Novo salário da vaga (em centavos).
- `zip_code` (string, opcional): Novo código postal (CEP) da vaga.

**Exemplo de Requisição:**

```json
{
  "short_description": "Desenvolvedor Frontend Júnior",
  "long_description": "Vaga para desenvolvedor frontend júnior com experiência em React.",
  "wage": 1040914,
  "zip_code": "14315-250"
}
```

**Exemplo de Resposta:**

```json
{
  "data": {
    "id": 1,
    "short_description": "Desenvolvedor Frontend Júnior",
    "long_description": "Vaga para desenvolvedor frontend júnior com experiência em React.",
    "wage": "1040914",
    "zip_code": "14315-250",
    "user_id": 5,
    "updated_at": "2024-05-18T00:00:00Z"
  }
}
```

### 5. Excluir Vaga

**Endpoint:** `DELETE /api/vacancies/{id}`

**Descrição:** Exclui uma vaga existente pelo ID.

**Exemplo de Resposta:**

```json
{
  "message": "Vaga excluída com sucesso."
}
```

---

## Listar Vagas Publicadas pelo Usuário

**Endpoint:** `GET /api/vacancies_user/my_published_vacancies`

**Descrição:** Retorna uma lista de vagas publicadas pelo usuário autenticado.

**Autenticação:** Bearer Token (necessário para acessar este endpoint).

### Resposta de Sucesso

**Código de Status:** `200 OK`

**Descrição:** Retorna uma lista de vagas publicadas pelo usuário autenticado.

**Formato da Resposta:**

```json
{
  "data": [
    {
      "id": 2,
      "created_at": "2024-05-26T22:40:21.000000Z",
      "updated_at": "2024-05-26T22:40:21.000000Z",
      "short_description": "test update",
      "long_description": "Fazendo teste de tal tal tal.",
      "wage": "R$ 7,77",
      "zip_code": "12345678",
      "user": {
        "id": 1,
        "name": "Erick",
        "email": "erick@jobs.com",
        "email_verified_at": "erick_verify@jobs.com",
        "created_at": "2024-06-04T01:42:02.000000Z",
        "updated_at": "2024-06-04T01:42:02.000000Z"
      }
    }
  ]
}
```

### Campos da Resposta

- **data**: Array contendo uma lista de vagas publicadas pelo usuário.
  - **id**: ID da vaga (inteiro).
  - **created_at**: Data e hora de criação da vaga (string, formato ISO 8601).
  - **updated_at**: Data e hora da última atualização da vaga (string, formato ISO 8601).
  - **short_description**: Descrição curta da vaga (string).
  - **long_description**: Descrição longa da vaga (string).
  - **wage**: Salário da vaga formatado (string).
  - **zip_code**: Código postal (CEP) da vaga (string).
  - **user**: Objeto contendo informações do usuário que publicou a vaga.
    - **id**: ID do usuário (inteiro).
    - **name**: Nome do usuário (string).
    - **email**: Email do usuário (string).
    - **email_verified_at**: Email verificado do usuário (string).
    - **created_at**: Data e hora de criação do usuário (string, formato ISO 8601).
    - **updated_at**: Data e hora da última atualização do usuário (string, formato ISO 8601).

### Exemplo de Requisição

```http
GET /api/vacancies_user/my_published_vacancies
Authorization: Bearer <your_access_token>
```

---

## Listar Vagas Aplicadas pelo Usuário

**Endpoint:** `GET /api/vacancies_user/my_applications_vacancies`

**Descrição:** Retorna uma lista de vagas para as quais o usuário autenticado se candidatou.

**Autenticação:** Bearer Token (necessário para acessar este endpoint).

### Resposta de Sucesso

**Código de Status:** `200 OK`

**Descrição:** Retorna uma lista de vagas aplicadas pelo usuário autenticado.

**Formato da Resposta:**

```json
{
  "data": [
    {
      "id": 2,
      "short_description": "test update",
      "long_description": "Fazendo teste de tal tal tal.",
      "wage": "R$ 7,77",
      "zip_code": "12345678",
      "user": {
        "id": 1,
        "name": "Erick",
        "email": "erick@jobs.com",
        "email_verified_at": "erick_verify@jobs.com",
        "created_at": "2024-06-04T01:42:02.000000Z",
        "updated_at": "2024-06-04T01:42:02.000000Z"
      }
    }
  ]
}
```

### Campos da Resposta

- **data**: Array contendo uma lista de vagas para as quais o usuário se candidatou.
  - **id**: ID da vaga (inteiro).
  - **short_description**: Descrição curta da vaga (string).
  - **long_description**: Descrição longa da vaga (string).
  - **wage**: Salário da vaga formatado (string).
  - **zip_code**: Código postal (CEP) da vaga (string).
  - **user**: Objeto contendo informações do usuário que publicou a vaga.
    - **id**: ID do usuário (inteiro).
    - **name**: Nome do usuário (string).
    - **email**: Email do usuário (string).
    - **email_verified_at**: Email verificado do usuário (string).
    - **created_at**: Data e hora de criação do usuário (string, formato ISO 8601).
    - **updated_at**: Data e hora da última atualização do usuário (string, formato ISO 8601).

### Exemplo de Requisição

```http
GET /api/vacancies_user/my_applications_vacancies
Authorization: Bearer <your_access_token>
```

---

## Endpoint: Aplicar ou Desaplicar de uma Vaga

**Endpoint:** `GET /api/vacancies_user/to_apply_or_unapply/{vacancy_id}`

**Descrição:** Aplica ou desaplica o usuário autenticado a uma vaga específica.

**Parâmetros:**

- **vacancy_id** (Path): ID da vaga (inteiro).
- **action** (Query): Ação a ser realizada, que pode ser "attach" (aplicar) ou "detach" (desaplicar).

**Autenticação:** Bearer Token (necessário para acessar este endpoint).

### Resposta de Sucesso

**Código de Status:** `200 OK`

**Descrição:** Mensagem de sucesso confirmando a ação realizada.

**Formato da Resposta:**

```json
{
  "message": "User John applied to Vacancy XYZ"
}
```

### Resposta de Erro

**Código de Status:** `404 Not Found`

**Descrição:** Mensagem de erro indicando dados ou ação inválidos.

**Formato da Resposta:**

```json
{
  "error": "Invalid data or action provided."
}
```

### Exemplo de Requisição

```http
GET /api/vacancies_user/to_apply_or_unapply/2?action=attach
Authorization: Bearer <your_access_token>
```

---

## Endpoint: Listar Usuários que Aplicaram para uma Vaga

**Endpoint:** `GET /api/vacancies_user/vacancy_applications/{vacancy_id}`

**Descrição:** Retorna uma lista de usuários que se candidataram a uma vaga específica.

**Parâmetros:**

- **vacancy_id** (Path): ID da vaga (inteiro).

**Autenticação:** Bearer Token (necessário para acessar este endpoint).

### Resposta de Sucesso

**Código de Status:** `200 OK`

**Descrição:** Retorna uma lista de usuários que aplicaram para a vaga especificada.

**Formato da Resposta:**

```json
{
  "data": [
    {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "created_at": "2024-06-09T12:00:00.000000Z",
      "updated_at": "2024-06-09T12:00:00.000000Z"
    }
  ]
}
```

### Campos da Resposta

- **data**: Array contendo uma lista de usuários que aplicaram para a vaga.
  - **id**: ID do usuário (inteiro).
  - **name**: Nome do usuário (string).
  - **email**: Email do usuário (string).
  - **created_at**: Data e hora de criação da aplicação do usuário (string, formato ISO 8601).
  - **updated_at**: Data e hora da última atualização da aplicação do usuário (string, formato ISO 8601).

### Resposta de Erro

**Código de Status:** `404 Not Found`

**Descrição:** Mensagem de erro indicando que a vaga não foi encontrada.

### Exemplo de Requisição

```http
GET /api/vacancies_user/vacancy_applications/2
Authorization: Bearer <your_access_token>
```

---
