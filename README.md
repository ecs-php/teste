# Descrição
Foi utilizado o framwork Silex para desenvolver uma api, foi utilizado também o Eloquent ORM para controle do banco de dados.
Para a autenticação foi utilizado autenticação Basic.<br>

Com esta autenticação, deve-se contonter os parametros `Authorization` e o `Content-Type`, no parametro `Authorization` deve conter uma autenticação `Basic` e o parametro `Content-Type` deve ser `application/json`.
A Autenticação é `admin:foo` utilizando a base64, tendo como resultado `Basic YWRtaW46Zm9`.
```
Authorization: Basic YWRtaW46Zm9v
Content-Type: application/json
```
## Banco de dados
O banco de dados utilizado foi `MySql`, para a criação do banco foi criado um comando `db:create` para o console do `Silex`, é possivel rodar o comando com `php bin/console db:create`.
Foi desenvolvido o comando `db:seed` para semear o bando para desenvolvimento, que pode ser usando como `php bin/console db:seed`.

## EndPoints

### Listagem de todos os recursos
```
GET /api/v1/person
```
Retorno:
```
[
    {

    }
]
```
### Busca de um recurso pelo ID
```
GET /api/v1/person/{id}
```
Retorno:
```
[
    {

    }
]
```
### Criação de um novo recurso
```
PUT /api/v1/person/
```
Retorno:
```
[
    {

    }
]
```
### Alteração de um recurso existente
```
PUT /api/v1/person/{id}
```
Retorno:
```
[
    {

    }
]
```
### Exclusão de um recurso
```
DELETE /api/v1/person/{id}
```
Retorno:
```
[
    {

    }
]
```

# A tarefa
Sua tarefa consiste em desenvolver uma API RESTful para manipular um determinado recurso. Deverá ser utilizado o framework Silex.

# Requisitos
A escolha do recurso deverá ser feita pelo desenvolvedor, atendendo apenas os requisitos mínimos abaixo:

* Deverá conter um ID
* Deverá conter pelo menos quatro propriedades (exemplos: nome, email, etc.)
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
* Banco de dados MySQL
* Framework Silex

# Fluxo de desenvolvimento
1. Faça um fork deste repositório
2. Crie uma nova branch e nomeie-a com seu usuário do Github
3. Quando o desenvolvimento estiver concluído, faça um pull request

# Padrões de nomenclatura
1. Código fonte, nome do banco de dados, tabelas e campos devem estar em inglês

**Inclua no seu commit todos os arquivos necessários para que possamos testar o código.**
