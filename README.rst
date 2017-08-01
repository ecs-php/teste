## Silex Application


* use the silex-app.sql to create the data base.
* change the config/prod.php configuration to connect the database.

start the server through line command by navigating to the application folder and typing `php -S localhost:7575 web/index.php`.


## Endpoints

Method|URL|SEGMENT|Params|Description
|-------|------:|-------:|-------:|--------:|
|GET|localhost:7575/api/v1 | /people | null | retrieve a list of all registers
|GET|localhost:7575/api/v1 | /people | /id | retrieve the information about one register
|POST|localhost:7575/api/v1 | /people | /{json data} | insert a new register on the database.
|PUT|localhost:7575/api/v1 | /people | / {json data} | update a register on the database.
|DELETE|localhost:7575/api/v1 | people | /id | delete a register on the data base.


## The JSON Object

The JSON object to be used on the insert and update methods should follow this structure:

```javascript
{
    "id" : "the id of the register (only informed when is a update)",
    "name" : "The Name of the person",
    "email" : "The Email of the person",
    "active" : "wheter the person is active or not. (1 - active, 0 - inactive)",
    "job" : "the job of the related person",
    "about" : "the description about this person"
}
```


## The Authorizarion Code

To be able to connect to the api you need to inform on the header of the request the authorization code. You cand create one direct on the database table users, from the start you can use the following code `0b39ec2ea2d9626c485942280bea3993`.

A valid request should look like this:
```
Authorization: 0b39ec2ea2d9626c485942280bea3993
Content-Type: json/application
Body: {json object}
....
```
