# Database
Import database: data/dump.sql
Configure connection in public/index.php

# Initialize
cd public
php -S localhost:8000

# JSON POST/PUT
{
	"name": "Teste Nome",
	"email": "testeemail@email.com",
	"password": "123456"
}