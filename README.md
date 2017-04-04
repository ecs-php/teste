Serasa Experian Test
============================================================
Develop a RESTful API to handle a given resource. See the [CHALLENGE.md](CHALLENGE.md).   
The chosen resource is `Product` with the following fields: `name`, `description`, `price`, `weight` and `active`.  


Install
------------------------------------------------------------
- Rename `.env.example` to `.env` and configure it;  
- Install dependencies: `composer install`  
- Update schema: `vendor/bin/doctrine o:s:u --force`  


Webserver
------------------------------------------------------------
Run PHP Builtin Webserver:

    cd public
    php -S localhost:8000


Routes
------------------------------------------------------------
If you want, [here](https://www.getpostman.com/collections/19a32cb8d97243625428) is my **Postman Collection** with all routes and examples.  
Anyway, the routes implemented are as follows:

### Authentication route
To authenticate you need to pass a json body with user and password (see your [.env](.env) file to get this data).  
The response will return an authentication token (JWT) on header and body.  

    POST /auth

### Products routes
To be able to do requests on this routes, you need to pass a *Authentication token* header returned on `/auth` route.
    
    GET /products
    GET /produts/{id}
    POST /produts
    PUT /produts/{id}
    DELETE /produts/{id}

    
Tests
------------------------------------------------------------
PHPUnit (you need to run the webserver first to be able to test controllers):

    vendor/bin/phpunit --configuration=tests/phpunit.xml
    
Code Sniffer:

    vendor/bin/phpcs --standard=phpcs.xml

Code Copy Detector:

    vendor/bin/phpcpd src/
    
Code Statistics:

    vendor/bin/phploc src/


Technologies
------------------------------------------------------------
To see used technologies see the [composer.json](composer.json) file.
    

Author
============================================================

* Frederico Wuerges Becker <fred.wuerges@gmail.com>