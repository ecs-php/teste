# Descrição do projeto
Usei o framework Silex para desenvolver a api em conjunto com o ORM Eloquent.
A api possui autenticação por chave de usuário chamada de `apikey`.<br>

Portanto o Header deve conter os seguintes parametros incluindo o `Content-type` devido a api aceitar apenas entradas e saídas em `json`

```
Authorization: 356a192b7913b04c54574d18c28d46e6395428ab
Content-Type: application/json
```

##Banco de dados
No banco de dados foi usado MySQL, e também foi implementado controle de versão da base atreavés do liquibase.
Para fins de teste está disponível o script de criação da base na pasta `resources`.
 
#ENDPOINTS
###Lista de todos os recursos
```
GET /api/v1/messages
```
Resposta:
```
[
     {
         "id": 4,
         "user_id": 1,
         "title": "Title 2",
         "body": "Body 2",
         "image_url": "https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_116x41dp.png",
         "source": "Google",
         "active": 1,
         "created_at": "2017-07-05 17:38:30",
         "updated_at": "2017-07-05 17:38:30",
         "user": {
             "id": 1,
             "name": "User 1",
             "email": "user1@user.com.br"
         }
     }
]
```
 
###Criar recurso
```
POST /api/v1/message
```
Body
```
{
    "title":"Title 2",
    "body":"Body 2",
    "image_url":"https:\/\/www.google.com\/images\/branding\/googlelogo\/1x\/googlelogo_color_116x41dp.png",
    "source":"Google"
}
```
Resposta
```
{
     "title": "Title 2",
     "body": "Body 2",
     "image_url": "https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_116x41dp.png",
     "source": "Google",
     "user_id": 1,
     "updated_at": "2017-07-07 12:57:00",
     "created_at": "2017-07-07 12:57:00",
     "id": 5,
     "user": {
         "id": 1,
         "name": "User 1",
         "email": "user1@user.com.br"
     }
}
```
 
###Buscar recurso por id
```
GET /api/v1/message/{id}
```
   
Resposta
```
[
  {
      "id": 1,
      "user_id": 1,
      "title": "Title 2",
      "body": "Body 2",
      "image_url": "https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_116x41dp.png",
      "source": "Google",
      "active": 1,
      "created_at": "2017-07-05 17:38:30",
      "updated_at": "2017-07-05 17:38:30",
      "user": {
          "id": 1,
          "name": "User 1",
          "email": "user1@user.com.br"
      }
  }
]
```
 
###Editar recurso
```
PUT /api/v1/message
```
Body
```
{
    "title":"Title 2",
    "body":"Body 2",
    "image_url":"https:\/\/www.google.com\/images\/branding\/googlelogo\/1x\/googlelogo_color_116x41dp.png",
    "source":"Google"
}
```

Resposta
```
{
  "title": "Title 2",
  "body": "Body 2",
  "image_url": "https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_116x41dp.png",
  "source": "Google",
  "user_id": 1,
  "updated_at": "2017-07-07 12:57:00",
  "created_at": "2017-07-07 12:57:00",
  "id": 5,
  "user": {
      "id": 1,
      "name": "User 1",
      "email": "user1@user.com.br"
  }
}
```
  
###Remover recurso
```
DELETE /api/v1/message/{id}
```
  
 Resposta
```
{"success":"Deleted"}
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
