

# ENDPOINTS

GET http://localhost:8000/users
* Rota genérica retornando um JSON para indicação de que um request válido é necessário.

GET http://localhost:8000/users
* Retorna uma lista de usuarios, sendo possível a passagem de parametros: limit e page na URL para auxilio na listagem.

GET http://localhost:8000/users/{id}
* Retorna um JSON com os dados de um usuário buscado.

POST http://localhost:8000/users
* URL para a criação de um novo Registro.

PUT http://localhost:8000/users/{id}
* URL para atualização de um usuário existente.

DELETE http://localhost:8000/users/{id}
* URL para que um usuário possa ser removido.

obs: Todas as requisições devem ser enviadas com parâmetro app_token que deverá estar disponível em $_REQUEST. Exemplo: http://localhost:8000/users?app_token=201705290110
O arquivo de tokens válidos para autenticação está em config/tokens.php e o mesmo é validado por middleware em App\Http\Middleware\AuthBasic.php

A Aplicação foi totalmente desenvolvida utilizando frameowk laravel 5.

Para que a aplicação funcione corretamente base:
1. Clonar o repositório a partir deste pull request.
2. navegar até o diretório e utilizar o comando: composer install.
3. Um servidor WEB é necessário. O laravel já possui servidor WEB embutido, nesta pasta é possível utilizar o comando "php artisan serve", os endpoints estarão disponíveis por padrão em http://localhost:8000, ou poderá ser utilizado o apache com a configuração do VHOST onde o document_root estará para a pasta public.
4. Exemplo de VHOST com apache:
<VirtualHost *:80>
	DocumentRoot C:\xampp\htdocs\ecs-teste\public
	ServerName dev.ecs-teste.com.br
	ServerAlias ecs-teste.com.br
	<Directory "C:\xampp\htdocs\ecs-teste\public">
		Options All Includes Indexes
		AllowOverride All
	<\/Directory>
<\/VirtualHost>
4.1 Configurar arquivo host para apontamento do DNS.
127.0.0.1 dev.ecs-teste.com.br 

__________________________________________________________________________________________

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
