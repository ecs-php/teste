# Serasa Test App

## Installation


Apps requires 

**PHP >= 7.0**

**NODE >= 7.6.0**

**MYSQL >= 5.6.35**

**Dependency management Composer**

**Dependency management NPM**

###Installation api-mock

```
cd api-mock
npm i
```

###Installation test-html

```
cd test-html
npm i
```

###Installation test-php

#### Edit Config app
```
/test-php/config/config.php
```

#### Install dependencies
```
cd test-php
composer install
```
#### Update schema

```
vendor/bin/doctrine o:s:u --force 
```


## Start HTML teste

```
cd api-mock
npm start
```

in a new terminal

```
cd test-html
npm start
```

Then open http://localhost:3000/ to see your app.

_**required to start api-mock for test-html operation**_



##WbService

Starting webservice

```
cd test-php/public
php -S localhost:8000

```

##Authentication route 

```
POST /api/v1/authentication

```

###Body
```
{
	"user":"admin",
	"password":"admin"
}
```

##Person routes
```
GET /api/v1/person
GET /api/v1/person/{id}
POST /api/v1/person
PUT /api/v1/person/{id}
DELETE /api/v1/person/{id}

```

Required token
```
Authorization - Bearer {token}
```
