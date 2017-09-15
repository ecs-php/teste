#README

-Necessario dar um composer install em todas dependencias

-Configurar banco de dados conforme seu ambiente. Utilieza o .sql que está na pasta BD.

Modo de teste:

-Feito apenas o back-end. Necessario usar o postman para testar. 

-Usuario Natan já criado. Use o mesmo para testar. Vá na aba Body, utileze "raw" -> JSON(application/json)
Cole o seguinte json no campo abaixo: (Que é um usuario já existente no bd).

		{

			"id" : 1,

			"name" : "Natan",

			"username" : "souzanatan",

			"password" : "natanpassword",

			"address" : "Rua Schnaider"

		}

-Com ele, será obrigado gerar um token indo para:

	METHOD POST -> http://localhost/teste/generate-token (necessario configurar conforme seu ambiente)

-Ele verificará se existe o mesmo existe no banco de dados para gerar token. (Sistema de login).

-Gerado o token, vá até a aba HEADERS, acrescendo uma nova key chamada "AuthorizationKey", e o value você coloca "Bearer TokenQueVocêGerouVemAqui". Deixe ele habilitado. (Como se você tivesse logado e entrasse no sistema).

-Agora você está autenticado para utilizar os endpoints. 