# Resolução

1. Para iniciar, abra o prompt de comando ou terminal e utilize `composer install`.
2. Então, em seu banco de dados mysql, utilize o arquivo `dump.sql` para gerar o banco. Caso não possua Mysql ou prefira utilizar outra solução, basta retirar os comentários na configuração pelos do servidor que deixei configurado. 
3. Caso estiver em ambiente Windows, dê 2 cliques no arquivo `server.bat`. Caso estiver em ambiente Unix, dentro do terminal digite `php -S localhost:8080 -t ./`.
4. Utilizar a API, abaixo seguem exemplos de utilização.

**Buscar Token**
```
curl -X POST \
  http://localhost:8080/login \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/json' \
  -d '{
	"username": "ROOT",
	"password": "MASTER"
}'
```
Utilizar o token retornado para as outras requisições

**Adicionar**
```
curl -X POST \
  http://localhost:8080/planets \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/json' \
  -H 'x-access-token: {token}' \
  -d '{
	"name": "Earth",
	"galaxy": "Milky Way",
	"size" : 6371,
	"distance": 0
}'
```

**Editar**
```
curl -X PUT \
  http://localhost:8080/planets/3 \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/json' \
  -H 'x-access-token: {token}' \
  -d '{
	"name": "Mars",
	"galaxy": "Milky Way",
	"size" : 3390,
	"distance": 225
}'
```

**Buscar todos**
```
curl -X GET \
  http://localhost:8080/planets \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/json' \
  -H 'x-access-token: {token}' 
}'
```

**Buscar um**
```
curl -X GET \
  http://localhost:8080/planets/9 \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/json' \
  -H 'x-access-token: {token}' 
}'
```

**Excluir específico**
```
curl -X DELETE \
  http://localhost:8080/planets/3 \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/json' \
  -H 'postman-token: 1b835774-cbf4-8534-235a-4dbbdfd6ae58' \
  -H 'x-access-token: {token}'
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
