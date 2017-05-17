# A tarefa
Sua tarefa consiste em desenvolver uma API RESTful para manipular um determinado recurso.

# Requisitos
A escolha do recurso deverá ser feita pelo desenvolvedor, atendendo apenas os requisitos mínimos abaixo:

* Deverá conter um ID
* Deverá conter pelo menos cinco propriedades (exemplos: nome, email, etc.)
* Deverá conter campos que armazenem as datas de criação e alteração do recurso

A API deverá atender às seguintes exigências:

* Listagem de todos os recursos
* Busca de um recurso pelo ID
* Criação de um novo recurso
* Alteração de um recurso existente
* Exclusão de um recurso
* Aceitar e retornar apenas JSON
* Deverá possuir algum método de autenticação para utilização de seus endpoints

# Ferramentas
* PHP
* Banco de dados SQLite
* Frameworks à escolha do desenvolvedor

# Fluxo de desenvolvimento
1. Faça um fork deste repositório
2. Crie uma nova branch e nomeie-a com seu usuário do Github
3. Quando o desenvolvimento estiver concluído, faça um pull request

# Padrões de nomenclatura
1. Código fonte, nome do banco de dados, tabelas e campos devem estar em inglês

**Inclua no seu commit todos os arquivos necessários para que possamos testar o código.**

# Iniciar o servidor
```bash
cd to/project/folder
bin/composer run
```

# Rodar suite de teste
```bash
cd to/project/folder
vendor/bin/phpunit
```

# Endpoints

## GET /book

### Request
```bash
curl -u admin:123 -H 'Accept: application/json' localhost:8888/book \
  | python -m json.tool
```

### Response Payload

```json
[
    {
        "author": "sadadads",
        "createdAt": "2017-05-17T09:53:54-03:00",
        "description": "teste",
        "id": "D18623D6-090F-41D5-9CE1-89AA6277DDEA",
        "isbn": "132131",
        "price": "11.99",
        "title": "teste",
        "updatedAt": "2017-05-17T09:53:54-03:00"
    },
    {
        "author": "sadadads",
        "createdAt": "2017-05-17T09:54:00-03:00",
        "description": "teste",
        "id": "E6AA5BAE-6D60-437E-9665-B88F63C268E1",
        "isbn": "132131",
        "price": "11.99",
        "title": "teste",
        "updatedAt": "2017-05-17T09:54:00-03:00"
    },
    {
        "author": "sadadads",
        "createdAt": "2017-05-17T09:54:42-03:00",
        "description": "teste",
        "id": "3C8A94EF-6259-4A3B-A11D-A9CDB22F28F6",
        "isbn": "132131",
        "price": "11.99",
        "title": "teste",
        "updatedAt": "2017-05-17T09:54:42-03:00"
    },
    {
        "author": "sadadads",
        "createdAt": "2017-05-17T10:27:25-03:00",
        "description": "teste",
        "id": "C55F1A77-5C8A-4510-A2C5-C4C84B51A154",
        "isbn": "132131",
        "price": "11.99",
        "title": "teste",
        "updatedAt": "2017-05-17T10:27:25-03:00"
    },
    {
        "author": "sadadads",
        "createdAt": "2017-05-17T10:27:42-03:00",
        "description": "teste",
        "id": "551450D3-3967-43E4-AA2B-6936351E3507",
        "isbn": "132131",
        "price": "11.99",
        "title": "teste",
        "updatedAt": "2017-05-17T10:27:42-03:00"
    },
    {
        "author": "sadadads",
        "createdAt": "2017-05-17T10:44:28-03:00",
        "description": "teste",
        "id": "34BD2774-8F17-4E33-A495-BFF60154242B",
        "isbn": "132131",
        "price": "11.99",
        "title": "teste",
        "updatedAt": "2017-05-17T10:44:28-03:00"
    }
]
```

## GET /book/:id

### Request
```bash
curl -u admin:123 -H 'Accept: application/json' localhost:8888/book/34BD2774-8F17-4E33-A495-BFF60154242B \
  | python -m json.tool
```

### Response Payload
```json
{
    "author": "sadadads",
    "createdAt": "2017-05-17T10:44:28-03:00",
    "description": "teste",
    "id": "34BD2774-8F17-4E33-A495-BFF60154242B",
    "isbn": "132131",
    "price": "11.99",
    "title": "teste",
    "updatedAt": "2017-05-17T10:44:28-03:00"
}
```

## POST /book

### Request
```bash
curl -v -H 'Accept: application/json' -H 'Content-Type: application/json' -u admin:123 -X POST \
  -d '{"title": "teste", "description": "teste", "isbn": "132131", "author": "sadadads", "price": "11.99"}' \
  localhost:8888/book | python -m json.tool
```

### Response Payload
```json
{
    "author": "sadadads",
    "createdAt": "2017-05-17T12:13:44-03:00",
    "description": "teste",
    "id": "CDEAACA6-1BD3-4D61-9970-BC7AF240C82C",
    "isbn": "132131",
    "price": "11.99",
    "title": "teste",
    "updatedAt": "2017-05-17T12:13:44-03:00"
}
```


## PATCH /book/:id

### Request
```bash
curl -v -u admin:123 -H 'Content-Type: application/json' -H 'Accept: application/json' -X PATCH \
  -d '{"title": "Hector Lazarote"}' \
  localhost:8888/book/CDEAACA6-1BD3-4D61-9970-BC7AF240C82C | python -m json.tool
```

### Response Payload
```json
{
    "author": "sadadads",
    "createdAt": "2017-05-17T12:13:44-03:00",
    "description": "teste",
    "id": "CDEAACA6-1BD3-4D61-9970-BC7AF240C82C",
    "isbn": "132131",
    "price": "11.99",
    "title": "Hector Lazarote",
    "updatedAt": "2017-05-17T12:20:15-03:00"
}
```

## DELETE /book/:id

### Request
```bash
curl -v -u admin:123  -H 'Accept: application/json' -X DELETE \
  localhost:8888/book/63124724-65EB-4DD1-8998-5E6046F8F60F | python -m json.tool
```

### Response Payload
```json
{
    "author": "sadadads",
    "createdAt": "2017-05-17T12:29:02-03:00",
    "description": "teste",
    "id": null,
    "isbn": "132131",
    "price": "11.99",
    "title": "teste",
    "updatedAt": "2017-05-17T12:29:02-03:00"
}
```