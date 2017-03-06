# Instalação do projeto
Para criação do projeto foi usado framework Laravel 5.4
Siga os passos abaixo para instalação do projeto local.

* Clonar projeto
* Abra o terminal no projeto e digite os seguintes comandos
* composer install
* php artisan migrate
* php artisan serve

Para obter o token:
* http://dominio/oauth/token | POST
* As informações abaixo precisam ser passada no body | x-www-form-urlencoded
* grant_type: password
* client_id: 2
* client_secret: JCCsAcdB6sgH3fsdlXFrS8p0rHf6JH0yseptwCiP
* username: user1@teste.com.br
* password: secret
* scope:

endPoints:
* http://dominio/api/client    | GET    | Lista todos clientes
* http://dominio/api/client    | POST   | Criar novo cliente
* http://dominio/api/client/id | PUT    | Atualizar cliente
* http://dominio/api/client/id | DELETE | Excluir cliente

Estrutura da tabela de clientes:
* id
* name
* email
* address
* city
* state
* birth_date
