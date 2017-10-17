# A Instalação
* Composer install <br>
* Executar o script localizado em data/schema.sql para a criação do BD, Tabela e Dados iniciais no MySQL.<br>
* Subir o servidor embutido do php, pois as configurações do silex foram codificadas para tal<br>

# Testes
* Recomenda-se utilizar o programa POSTMAN para executar as requisições<br>
* A API somente aceita somente JSON como estrutura de dados.
* Todas as requisições devem conter o header(Content-Type:application/json).
* Executar a autenticação através da url http://servidor:porta/books/api/auth com as seguintes keys(email:macedodosanjosmateus@gmail.com, password:123Mudar).
* Copiar o token de autenticação para as futuras requisições.
* Incluir nas requisições dos endpoints o header(Authorization:token-gerado-na-auth).

# OBS
* Na implementação da autenticação não foram aprofundados questões como
    * Consulta ao BD por usuario.
    * Encriptação da senha do usuario.
    * Validação da expiração do token.
    
<h3>Bons Testes</h3>
<h5>By Mateus Macedo Dos Anjos <macedodosanjosmateus@gmail.com></h5>

