<?php

require __DIR__ . '/vendor/autoload.php';

date_default_timezone_set('America/Sao_Paulo');

$app = new Silex\Application();

$app->register(new BookStore\Provider\AppServiceProvider());

if (php_sapi_name() != 'cli') {
    exit('Rodar via CLI');
}
$con = $app['db'];

$schema = new Doctrine\DBAL\Schema\Schema;
$sManager = $con->getSchemaManager();

$table = $schema->createTable('tbl_book');

$table->addColumn('id', 'integer', [
    'unsigned' => true,
    'autoincrement' => true
]);
$table->addColumn('title', 'string', ['length' => 100]);
$table->addColumn('description', 'text');
$table->addColumn('plain', 'decimal', ['scale' => 2]);
$table->addColumn('author', 'string', ['length' => 100]);
$table->addColumn('dt_register', 'datetime');
$table->addColumn('dt_update', 'datetime');
$table->setPrimaryKey(['id']);

$platform = $con->getDatabasePlatform();

$create = $schema->toSql($platform);

if ($sManager->tablesExist('tbl_book')) {
    $drop = $schema->toDropSql($platform);
    $con->exec($drop[0]);
    unset($drop);
}

$con->exec($create[0]);
unset($create);

$con->insert('tbl_book', [
    'title' => 'Clean Code',
    'description' => 'Tudo sobre boas práticas de programação',
    'plain' => 345.00,
    'author' => 'Johnny Hideki',
    'dt_register' => date('Y-m-d H:i:s'),
    'dt_update' => date('Y-m-d H:i:s')
]);

$con->insert('tbl_book', [
    'title' => 'Design Patter',
    'description' => 'Todos os padrões em um livro só',
    'plain' => 245.00,
    'author' => 'Bernardo Hikaru',
    'dt_register' => date('Y-m-d H:i:s'),
    'dt_update' => date('Y-m-d H:i:s')
]);


$con->insert('tbl_book', [
    'title' => 'Livro de Photoshop CS5',
    'description' => 'Como usar a ferramenta!',
    'plain' => 125.00,
    'author' => 'Evelyn T. S.',
    'dt_register' => date('Y-m-d H:i:s'),
    'dt_update' => date('Y-m-d H:i:s')
]);

