## Executar o projeto

```
clone este repositório <dir>

cd <dir>

cd api

composer install

docker-compose up -d
```

### Fron
```
http://localhost
```

### Api

```
http://localhost/api

/winners [post, get]
post: {"first_name": "John", "last_name": "Doe", "identity":"408641940", "birthday": "1-01-01", "city": "São Paulo", "state": "SP"}
/winners/id [put, delete]

/draws [post, get]
post: {"date": "2017-11-22", "winner_id": Inteiro ou Nulo}
/draws/id [put, delete]

```
adicionar na header: Authorization e Contentt-Type 
```
Content-Type:application/json
Authorization:1029371929182

```

Requerimentos

PHP ^7.1.x
Composer

Docker ^17.02.2-ce
Docker-compose

### Obs

se necessário alterar o ip do docker em <dir>/.env

### Testes

```
cd <dir>

vendor/bin/behat
```