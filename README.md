# Sobre o projeto
Eu escolhi algumas publicações do site da GFT Brasil como o recurso da minha API. De acordo com os requisitos, é possível inserir/alterar/remover as publicações.

# Deploy
* Configurar as credenciais do banco de dados em src/app.php
* Importar o arquivo database.sql que está na raíz

# Instruções de uso
* Nome do recurso com as publicações: releases
* Obter token com PUT /tokens e JSON body {"username": "gft", "password": "1234"}
* Repassar o token em todos os endpoints como parâmetro GET _token. Exemplo: /releases?_token=e3b50681ffdf0fbe7dfb25acbb809ed0 (o token não possui expiração)
* Os usuários podem ser incluídos somente diretamente no banco de dados
* No endpoint GET /releases, é possível enviar um parâmetro "query" para efetuar uma busca fulltext