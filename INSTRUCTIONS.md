# API SERASA
### Requisitos:
  - PHP >= 5.6
  - Composer
  - SQL >= 4.0.4
### Ferrameta para testar a API:
  - Postman ou qualquer UI semelhante para testar API's
### Instalação:
```sh
$ cd teste
$ composer install
```
### Importação do banco de dados:
Via phpmyadmin importe o arquivo dump.sql que está na raiz do projeto
![img](http://i.imgur.com/AZ7YVi8.png)
Não há necessidade de criar banco, apenas execute o arquivo
![img](http://i.imgur.com/jTwxy3c.png)

# API
Há 2 formas simples de subir a aplicação:
### 1º vhost configurado via apache:
```sh
NameVirtualHost 127.0.0.1:8080

Listen 127.0.0.1:8080

<VirtualHost 127.0.0.1:8080>
  DocumentRoot "/path/to/your/project/public"
  DirectoryIndex index.php
  <Directory "/path/to/your/project/public">
    AllowOverride All
    Allow from All
  </Directory>
</VirtualHost>
```
### 2º PHP Built-in Web Server:
```sh
$ php -S localhost -t /path/to/your/project/public
```
ou estando na raiz do projeto:
```sh
$ php -S localhost:8080 -t public
```

Metodos disponíveis:
-
- Todas as requisições devem conter um Header Token não nulo, com qualquer valor.
- Todas as requisições [POST | PUT | DELETE] possuem validações de obrigatoriedade e verificação de tipos de dados. 
```sh
GET /
GET /user
GET /user/:id
POST /user
PUT /user/:id
DELETE /user/:id
```

### GET /
Retorna um JSON com nome da API e versão

Headers [
    Token:csazevedo
]

![img](http://i.imgur.com/c4ucY9b.jpg)

### GET /user
Retorna um JSON com 2 atributos sendo quantidade de registros e uma lista dos recursos.

Headers [
 Token:csazevedo
]

![img](http://i.imgur.com/TDpfNZt.jpg)

### GET /user/:id
Retorna um JSON de um recurso específico

Headers [
 Token:csazevedo
]

![img](http://i.imgur.com/Q7A4Aq2.jpg)


### POST /user
Cria um novo recurso

Headers [
 Token:csazevedo
 Content-Type:application/x-www-form-urlencoded
]

FormData [
    name: Campo obrigatório
    age: Campo obrigatório, somente inteiro
    country: Campo obrigatório
    email: Campo obrigatório e e-mail válido
]

![img](http://i.imgur.com/gA2rhX4.jpg)

### PUT /user/:id
Atualiza um recurso

Headers [
 Token:csazevedo
 Content-Type:application/x-www-form-urlencoded
]

FormData [
    name: Campo obrigatório
    age: Campo obrigatório, somente inteiro
    country: Campo obrigatório
    email: Campo obrigatório e e-mail válido
]

![img](http://i.imgur.com/fjr4Qpc.jpg)

### DELETE /user/:id
Remove um recurso

Headers [
 Token:csazevedo
]

![img](http://i.imgur.com/zSV3HEj.jpg)


