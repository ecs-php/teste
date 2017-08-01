TESTE LAYOUT
*******************************************************************

Disponível em /serasa-layout, conforme especificado pela empresa


TESTE API
*******************************************************************

===================================================================
Instalar Micro Framework
===================================================================

Instale através do composer, utilizando o comando:

composer require silex/silex "~2.0"

Atualize as dependencias conforme composer.json



===================================================================
Estrutura
===================================================================

Modelo estrutural do projeto:

/serasa-api
    /public
      .htaccess
      database.php
      index.php
    /src
      /API
        /Middleware
          Authentication.php
          Logging.php
        /Models
          User.php
          Winner.php
    /vendor
      - todos os componentes do framework
  composer.json
  composer.lock
  database.sql



===================================================================
composer.json
===================================================================

Importante adicionar a dependencia e configurar o autoload conforme diretório de sua preferência, no caso, optei por
utilizar API\\ setando para o diretório src/API.

    "require": {
        "illuminate/database": "~5.2"
    },
    "autoload": {
        "psr-4": { "API\\": "src/API" }
    },



===================================================================
.htaccess
===================================================================

Configure o arquivo .htaccess parametrizando o diretório (no caso, serasa-api/public)

OBS:.
->> O modo mod_rewrite deve estar ativo em suas configurações do apache;
->> Não alterar o HTTP:Authorization;
->> Qualquer alteração no apache, não esqueça de reinicia-lo;

<IfModule mod_rewrite.c>
    Options -MultiViews
    RewriteEngine On
    RewriteBase /serasa-api/public/
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [QSA,L]

    #Cabeçalho de autorização API
    RewriteCond %{HTTP:Authorization} ^(.+)$
    RewriteRule ^ - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
</IfModule>


===================================================================
Base de dados
===================================================================

Configurar a base de dados conforme especificações do servidor ou máquina local

Arquivo: serasa-api/public/database.php

$capsule->addConnection([
    "driver"    => "mysql",
    "host"      => "DADOS DO HOST",
    "database"  => "NOME DA BASE", // sugestão: serasa_api
    "username"  => "USUÁRIO",
    "password"  => "SENHA",
    "charset"   => "utf8",
    "collation" => "utf8_general_ci",
    "prefix"    => ""
]);

Após criação da base, carregue os dados conforme arquivo database.sql, criando as tabelas e os registros.



===================================================================
Postman
===================================================================

Após efetuar login na ferramenta, utilize os dados abaixo para efetuar os testes.

Aba HEADERS:
key = Authorization // .htaccess
value = aacba679caf6b32ae486698c44ff7d19 // campo::apikey -> tabela::users

Configurado, utilize os dados abaixo para efetuar os testes.

-------------------------------------------------------------------------------

Retornar todos os registros:
GET = http://localhost/serasa-api/public/winners

CLICAR EM SEND





-------------------------------------------------------------------------------

Retornar apenas registro consultado:
GET = http://localhost/serasa-api/public/winner/ID_DO_REGISTRO // Exemplo: ID_DO_REGISTRO => 1

CLICAR EM SEND




-------------------------------------------------------------------------------

Cadastrar novo registro:
POST = http://localhost/serasa-api/public/winner/create

Na aba BODY:
-> Selecionar form-data
-> Cadastrar campos
    key = winnerName     |    value = NOME WINNER   // EX:. ANDERSON MARTINS
    key = winnerEmail    |    value = EMAIL WINNER  // EX:. anderson.com@gmail.com
    key = winnerCpf      |    value = CPF WINNER    // EX:. 11122233344
    key = winnerCity     |    value = CIDADE WINNER // EX:. BLUMENAU
    key = winnerState    |    value = ESTADO WINNER // EX:. SC

CLICAR EM SEND




-------------------------------------------------------------------------------

Exclui registro:
DELETE = http://localhost/serasa-api/public/winner/delete/ID_DO_REGISTRO // Exemplo: ID_DO_REGISTRO => 3

CLICAR EM SEND
