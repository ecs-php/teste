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


# API de Contato

## Observações
```
O sistema foi desenvolvido como uma API para envio e recebimento de contatos
O banco de dados SqLite já está configurado, porém o sistema aceita a utilização do MySql como banco de dados.
```

## Configurações
1 - habilitar a conexão PDO e o SQLITE
```
extension=php_pdo.dll
extension=php_sqlite.dll
```
2 - criar um vhost
```
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/contato.local"
    ServerName contato.local
    ErrorLog "logs/contato_local-error.log"
    CustomLog "logs/contato_local-access.log" common
</VirtualHost>
```
3 - redirecionar o hosts
```
* C:\Windows\System32\drivers\etc\hosts
* 127.0.0.1	contato.local
```
	
4 - testar URL
* Validar se retorna o seguinte texto
```
Contacts
Developer: Caio Santos
Email: santoscaio@gmail.com
```

5 - Efetuar as requisições com o seguinte usuário e senha
```
usuário: ecs-php
senha: santoscaio
```

## Endpoints (*CRUD de contato*)
- Todos os retornos são respondidos em HTTP mais a informação em JSON
- Atualmente uso o postman para consumo e teste de api's
- Inserir contato
    - Insere um novo contato no banco de dados
    - method: **POST**
    - http://contato.local/contato
    - Campos: **[nome, email, telefone, descricao]**
    - Campos **obrigatórios: [nome, email, descricao]**
    - Retorno: **id**
- Atualizar contato
    - Atualiza um contato no banco de dados
    - method: **PUT**
    - http://contato.local/contato/[id]
    - Campo obrigatório: **[id]**
    - Campos opcionais: **[nome, email, telefone, descricao]**
    - Retorno: **id**
    - Exemplo: http://contato.local/contato/1
- Buscar contato
    - Busca um contato no banco de dados
    - method: **GET**
    - http://contato.local/contato/[id]
    - Campo obrigatório: **[id]**
    - Retorno: **dados do contato**
    - Exemplo: http://contato.local/contato/1
- Deletar contato
    - Deleta um contato no banco de dados
    - method: **DELETE**
    - http://contato.local/contato/[id]
    - Campo obrigatório: **[id]**
    - Retorno: **id**
    - Exemplo: http://contato.local/contato/1

# Extra Documentation
## Semantics and Content of HTTP
https://tools.ietf.org/html/rfc7231

## List of HTTP status codes
https://en.wikipedia.org/wiki/List_of_HTTP_status_codes


# Lumen PHP Framework
## Official Documentation
Documentation for the framework can be found on the [Lumen website](http://lumen.laravel.com/docs).

## License
The Lumen framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
