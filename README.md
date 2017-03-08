### Tecnologias utilizadas:
- Composer
- Silex
- Doctrine
- MySQL
- Servidor Web: Nginx + PHP-FPM
- PHP 7.0

### Arquivos inclusos:
- **data/Test.postman_collection.json** - Arquivo do Postman com as rotas criadas e a autenticação configurada para Basic Auth.
- **data/db.sql** - Arquivo com o Dump do Banco de Dados

### Como configurar o projeto:
1. Rodar o comando "php composer.phar install"

2. Criar o banco de dados

3. Configurar o arquivo .env. Arquivo fica na raíz do projeto (.env.example) deve-ser criar um arquivo .env na raíz do projeto e configurar as seguintes informações:
* ENVIRONMENT = Ambiente que está rodando (Produção, desenvolvimento, etc.)
* HOST = host do banco de dados
* USER = usuário do banco de dados
* PASSWORD = senha do usuário do banco de dados
* DATABASE = nome do banco de dados
* DEBUG = modo debug | true ou false

4. Adicionar a pasta data/Proxy com permissão para escrita

5. Rodar o comando **bin/doctrine orm:schema-tool:update --dump-sql -f** para criar as entidades no banco de dados (Também pode importar o db.sql caso preferir)

### Configurações Nginx que foram utilizadas:
```
server {
    listen       80;
    server_name  local.capgemini;
   
    root   /var/www/local.capgemini/public;
    index index.php index.html index.htm;
    access_log /var/log/nginx/local.capgemini-access;
    error_log /var/log/nginx/local.capgemini-error;

    location / {
          try_files $uri $uri/ /index.php?$args;
          fastcgi_read_timeout 5m;
          index index.html index.htm index.php;
    }

    error_page 404 /404.html;
    error_page 500 502 503 504 /50x.html;
    location = /50x.html {
        root /usr/share/nginx/html;
    }

    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_pass unix:/run/php/php7.0-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        #fastcgi_param ENVIRONMENT staging;
        include fastcgi_params;
    }
}
```

## Documentação da API

### Modo de Autenticação:
- Utilizado Basic Auth
- Usuário: teste
- Senha: teste123

### Rota:
**Método e Recurso:** GET - /person

**Descrição:** Lista todas as pessoas

**Json retorno:**
```
{
  "code": 200,
  "message": "Requisição efetuada com sucesso.",
  "data": [
    {
      "first_name": "André",
      "last_name": "Felipe",
      "email": "email@email.com",
      "gender": "M",
      "is_active": true,
      "id": 2,
      "created_at": {
        "date": "2017-03-08 06:53:35.000000",
        "timezone_type": 3,
        "timezone": "America/Sao_Paulo"
      },
      "updated_at": null,
      "deleted_at": null
    },
    {
      "first_name": "João",
      "last_name": "Almeida",
      "email": "joao@email.com",
      "gender": "M",
      "is_active": true,
      "id": 3,
      "created_at": {
        "date": "2017-03-08 06:54:45.000000",
        "timezone_type": 3,
        "timezone": "America/Sao_Paulo"
      },
      "updated_at": null,
      "deleted_at": null
    },
    {
      "first_name": "Rafaela",
      "last_name": "Garcia",
      "email": "rafaela@email.com",
      "gender": "F",
      "is_active": true,
      "id": 4,
      "created_at": {
        "date": "2017-03-08 06:54:59.000000",
        "timezone_type": 3,
        "timezone": "America/Sao_Paulo"
      },
      "updated_at": null,
      "deleted_at": null
    }
  ]
}
```

### Rota:
**Método e Recurso:** GET - /person/{id}

**Descrição:** Busca apenas uma pessoa por ID

**Json retorno:**
```
{
  "code": 200,
  "message": "Requisição efetuada com sucesso.",
  "data": {
    "first_name": "André",
    "last_name": "Felipe",
    "email": "email@email.com",
    "gender": "M",
    "is_active": true,
    "id": 1,
    "created_at": {
      "date": "2017-03-08 06:53:35.000000",
      "timezone_type": 3,
      "timezone": "America/Sao_Paulo"
    },
    "updated_at": null,
    "deleted_at": null
  }
}
```

### Rota:
**Método e Recurso:** POST - /person

**Descrição:** Cria uma pessoa

**Json envio:**
```
{
	"first_name": "André",
	"last_name": "Felipe",
	"email": "email@email.com",
	"gender": "M",
	"active": true
}
```

**Json retorno:**
```
{
  "code": 200,
  "message": "Requisição efetuada com sucesso.",
  "data": {
    "first_name": "André",
    "last_name": "Felipe",
    "email": "email@email.com",
    "gender": "M",
    "is_active": true,
    "id": 5,
    "created_at": {
      "date": "2017-03-08 06:58:03.000000",
      "timezone_type": 3,
      "timezone": "America/Sao_Paulo"
    },
    "updated_at": null,
    "deleted_at": null
  }
}
```

### Rota:
**Método e Recurso:** PUT - /person

**Descrição:** Atualiza uma pessoa com base no seu ID

**Json envio:**
```
{
	"id": 1,
	"first_name": "André alterado",
	"last_name": "Felipe",
	"email": "email@email.com",
	"gender": "M",
	"active": false
}
```

**Json retorno:**
```
{
  "code": 200,
  "message": "Requisição efetuada com sucesso.",
  "data": {
    "first_name": "André alterado",
    "last_name": "Felipe",
    "email": "email@email.com",
    "gender": "M",
    "is_active": false,
    "id": 1,
    "created_at": {
      "date": "2017-03-08 06:53:35.000000",
      "timezone_type": 3,
      "timezone": "America/Sao_Paulo"
    },
    "updated_at": {
      "date": "2017-03-08 06:59:32.000000",
      "timezone_type": 3,
      "timezone": "America/Sao_Paulo"
    },
    "deleted_at": null
  }
}
```

### Rota:
**Método e Recurso:** DELETE - /person/{id}

**Descrição:** Deleta uma pessoa com base em seu ID

**Json retorno:**
```
{
  "code": 200,
  "message": "Requisição efetuada com sucesso.",
  "data": {
    "first_name": "André alterado",
    "last_name": "Felipe",
    "email": "email@email.com",
    "gender": "M",
    "is_active": false,
    "id": 1,
    "created_at": {
      "date": "2017-03-08 06:53:35.000000",
      "timezone_type": 3,
      "timezone": "America/Sao_Paulo"
    },
    "updated_at": {
      "date": "2017-03-08 06:59:32.000000",
      "timezone_type": 3,
      "timezone": "America/Sao_Paulo"
    },
    "deleted_at": {
      "date": "2017-03-08 07:00:23.000000",
      "timezone_type": 3,
      "timezone": "America/Sao_Paulo"
    }
  }
}
```