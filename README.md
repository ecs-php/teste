#Prova Técnica - Alexandre Feustel Baehr

#Requisitos:

1) Composer;

2) PHP >=5.6.4;

3) MySQL 5.5.

#Ferramentas/frameworks utilizados:

1) Laravel 5.3;

2) MySQL 5.5;

3) Postman;

#Instruções:

1) Clonar o projeto

2) Navegar até a pasta criada (exemplo)

 ```$ cd teste```

3) Executar o Composer 

```$ composer install```

4) Crie um banco de dados 

```CREATE DATABASE `alebae-backend` /*!40100 COLLATE 'utf8_general_ci' */;```

5) Rodar as migrations para gerar as tabelas do banco de dados

```$ php artisan migrate```

6) Habilitar o servidor embutido no PHP.

```$ php artisan serve```

7) Utilizar algum plugin REST Client como o Postman ou RESTClient
   a) Para a listagem dos usuários, escolha o método GET para a URL http://localhost:8000/teste (Sendo 8000 a porta que for indicada no Console, no momento da habilitação do servidor PHP);
   ![alt tag](http://i.imgur.com/4jZ8pjz.png)

   b) Para a listagem de um registro específico, escolha o método GET para a URL http://localhost:8000/teste/1 (onde o número 1 será o ID do registro);
   ![alt tag](http://i.imgur.com/r6xkeqv.png)

   c) Para a inserção de um novo usuário, escolha o método POST para a URL http://localhost:8000/teste/, informando os Headers com a key "Content-Type" e o value "application/x-www-form-urlencoded"...
   ![alt tag](http://i.imgur.com/BQzOQYg.png)

   ...insira para "Body" as keys "name", "phone", "cpf", "email" com seus respectivos valores...
   ![alt tag](http://i.imgur.com/TbBrDuL.png)

   ...após isto, clique em "Send" para cadastrar os valores;
   ![alt tag](http://i.imgur.com/SKEqX2m.png)
   
   d) Para alterar valores, basta alterar para o método PUT e informar o ID desejado para a URL http://localhost:8000/teste/1 (exemplo), alterando os valores no campo "Body"
   ![alt tag](http://i.imgur.com/ksB4uxF.png)

   e) Para excluir um registro, basta alterar para o método DELETE e informar o ID desejado para a URL http://localhost:8000/teste/1 (exemplo) 
   ![alt tag](http://i.imgur.com/a8FfJil.png)
