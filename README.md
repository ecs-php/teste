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


******************************************************************************************************************

BRUNO CARAMELO SOUZA

Passos para uso

1 - baixar repositório

2 - executar : composer install

3 - executar : php artisan migrate --force

4 - executar : php artisan db:seed

5 - executar : phpunit na raiz do projeto caso o mesmo for instalado como global


O projeto foi baseado em TDD , contendo teste de unidade para a entidade Employee como serviço e como modulo.
com testes de HTTP, autenticação baseada em tokens.

O sqlite será alimentado pelo migrate , e seus dados pelo seed, sendo usados para a bateria de testes e para a aplicação vistos em app/database/migrations e seeds

---------------------------------------------------------------------------------------------------------

ROTAS


- Listar Todos os employees
	http://host.desejado/api/v1/employees
	- POST 
	- parametros: 'api_token' = 8de70cb01900c98625fd6f484fc1468ba2fadb93

- Recuperar employee
	http://host.desejado/api/v1/employee/{id}
	- POST 
	- parametros: 'api_token' = 8de70cb01900c98625fd6f484fc1468ba2fadb93

- Criar employee
	http://host.desejado/api/v1/employee/create
	- POST 
	- parametros: 
		'name' = String,
        'email' = String,
        'address' = String,
        'number' = String,
        'phone' = Number,
        'cpf' = Number,
		'api_token' = 8de70cb01900c98625fd6f484fc1468ba2fadb93


- Editar employee
	http://host.desejado/api/v1/employee/update/{id}
	- POST 
	- parametros: 
		'id' = Number,
		'name' = String,
        'email' = String,
        'address' = String,
        'number' = String,
        'phone' = Number,
        'cpf' = Number,
		'api_token' = 8de70cb01900c98625fd6f484fc1468ba2fadb93

- Excluir employee
	http://host.desejado/api/v1/employee/remove/{id}
	- POST 
	- parametros: 'api_token' = 8de70cb01900c98625fd6f484fc1468ba2fadb93
