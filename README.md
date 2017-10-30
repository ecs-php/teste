**Ambiente utilizado**
* PHP 7.0.4
* MySQL 5.7.11

1. Criar o bando de dados rodando o script _`database.sql`_
2. Acessar a raiz do projeto pelo terminal e digitar o comando `composer install`
3. Ainda no terminal digitar o comando `php -S localhost:80 -t application/`

**Autenticação** 
```
curl -X POST http://localhost:80/login -H 'content-type: application/json' -d '{"user":"admin", "password":"123"}'
```
**Observação:** Salvar o token retornado para as demais requisições

**Listar todos**
```
curl -X GET http://localhost:80/livros -H 'cache-control: no-cache' -H 'content-type: application/json' -H 'x-access-token: {token}'
```
**Listar um**
```
curl -X GET http://localhost:80/livro/{id} -H 'cache-control: no-cache' -H 'content-type: application/json' -H 'x-access-token: {token}'
```
**Inserir**
```
curl -X POST http://localhost:80/livro -H 'cache-control: no-cache' -H 'content-type: application/json' -H 'x-access-token: {token}' -d '{"title": "{valor}", "author": "{valor}", "publishing_company": "{valor}", "pages": {valor}}'
```
**Alterar**
```
curl -X PUT http://localhost:80/livro/{id} -H 'cache-control: no-cache' -H 'content-type: application/json' -H 'x-access-token: {token}' -d '{"title": "{valor}", "author": "{valor}", "publishing_company": "{valor}", "pages": {valor}}'
```
**Deletar**
```
curl -X DELETE http://localhost:80/livro/{id} -H 'cache-control: no-cache' -H 'content-type: application/json' -H 'x-access-token: {token}'
```