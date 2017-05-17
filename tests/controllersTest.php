<?php

use Silex\WebTestCase;

class controllersTest extends WebTestCase
{
    public function setUp()
    {
        parent::setUp();

        $db = $this->app['db'];

        $db->query('DELETE FROM book');

        $db->insert('book', array(
            'id' => '4DB2E160-30BA-42D6-9CB3-7F5B946E966B',
            'isbn' => '9788582354315',
            'title' => 'Amor Para Um Escocês',
            "author" => "Maclean, Sarah",
            "description" => "Se você quer romance, chame um escocês.",
            "price" => "26.50",
            'created_at' => '200-05-17',
            'updated_at' => '200-05-17',
        ));

        $db->insert('book', array(
            'id' => '3DB2E160-30BA-42D6-9CB3-7F5B946E966C',
            'isbn' => '9788582354315',
            'title' => 'Amor Para Um Escocês',
            "author" => "Maclean, Sarah",
            "description" => "Se você quer romance, chame um escocês.",
            "price" => "26.50",
            'created_at' => '200-05-17',
            'updated_at' => '200-05-17',
        ));
    }

    public function testCreateBookShouldReturn401()
    {
        $client = $this->createClient(array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'abc',
            'HTTP_Accept' => 'application/json',
            'CONTENT_TYPE' => 'application/json'
        ));

        $client->request('POST', '/book', [], [], [], '{}');

        $this->assertEquals('401', $client->getResponse()->getStatusCode());
    }

    public function testCreateBook()
    {
        $client = $this->createClient(array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => '456',
            'HTTP_Accept' => 'application/json',
            'CONTENT_TYPE' => 'application/json'
        ));

        $client->request('POST', '/book', [], [], [], '{
            "isbn": "9788582354315",
            "title": "Amor Para Um Escocês",
            "author": "Maclean, Sarah",
            "description": "Se você quer romance, chame um escocês.",
            "price": "26.50"
        }');

        $this->assertEquals('201', $client->getResponse()->getStatusCode());
        $this->assertEquals('application/json', $client->getResponse()->headers->get('Content-Type'));
    }


    public function testCreateShouldReturn406WhenContentTypeIsHtml()
    {
        $client = $this->createClient(array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => '456',
            'HTTP_Accept' => 'application/json',
            'CONTENT_TYPE' => 'text/html'
        ));

        $client->request('POST', '/book', [], [], [], '{
            "isbn": "9788582354315",
            "title": "Amor Para Um Escocês",
            "author": "Maclean, Sarah",
            "description": "Se você quer romance, chame um escocês.",
            "price": "26.50"
        }');

        $this->assertEquals('406', $client->getResponse()->getStatusCode());
    }

    public function testCreateShouldReturn406WhenAcceptIsHtml()
    {
        $client = $this->createClient(array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => '456',
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'text/html',

        ));

        $client->request('POST', '/book', [], [], [], '{
            "isbn": "9788582354315",
            "title": "Amor Para Um Escocês",
            "author": "Maclean, Sarah",
            "description": "Se você quer romance, chame um escocês.",
            "price": "26.50"
        }');

        $this->assertEquals('406', $client->getResponse()->getStatusCode());
    }

    public function testUpdateBookShouldReturn401()
    {
        $client = $this->createClient(array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'abc',
            'HTTP_Accept' => 'application/json',
            'CONTENT_TYPE' => 'application/json'
        ));

        $client->request('PATCH', '/book/3DB2E160-30BA-42D6-9CB3-7F5B946E966C', [], [], [], '{}');

        $this->assertEquals('401', $client->getResponse()->getStatusCode());
    }


    public function testUpdateBook()
    {
        $client = $this->createClient(array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => '456',
            'HTTP_Accept' => 'application/json',
            'CONTENT_TYPE' => 'application/json'
        ));

        $client->request('PATCH', '/book/3DB2E160-30BA-42D6-9CB3-7F5B946E966C', [], [], [], '{
            "title": "Amor Para Um Brasilerio"
        }');

        $this->assertEquals('200', $client->getResponse()->getStatusCode());
        $this->assertEquals('application/json', $client->getResponse()->headers->get('Content-Type'));
        $this->assertContains('Amor Para Um Brasilerio', $client->getResponse()->getContent());
    }

    public function testUpdateBookShouldReturn404()
    {
        $client = $this->createClient(array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => '456',
            'HTTP_Accept' => 'application/json',
            'CONTENT_TYPE' => 'application/json'
        ));

        $client->request('PATCH', '/book/3DB2E160-30BA-', [], [], [], '{
            "title": "Amor Para Um Brasilerio"
        }');

        $this->assertEquals('404', $client->getResponse()->getStatusCode());
    }

    public function testUpdateShouldReturn406WhenContentTypeIsHtml()
    {
        $client = $this->createClient(array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => '456',
            'HTTP_Accept' => 'application/json',
            'CONTENT_TYPE' => 'text/html'
        ));

        $client->request('PATCH', '/book/3DB2E160-30BA-42D6-9CB3-7F5B946E966C', [], [], [], '{
            "isbn": "9788582354315",
            "title": "Amor Para Um Escocês",
            "author": "Maclean, Sarah",
            "description": "Se você quer romance, chame um escocês.",
            "price": "26.50"
        }');

        $this->assertEquals('406', $client->getResponse()->getStatusCode());
    }

    public function testUpdateShouldReturn406WhenAcceptIsHtml()
    {
        $client = $this->createClient(array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => '456',
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'text/html',

        ));

        $client->request('PATCH', '/book/3DB2E160-30BA-42D6-9CB3-7F5B946E966C', [], [], [], '{
            "isbn": "9788582354315",
            "title": "Amor Para Um Escocês",
            "author": "Maclean, Sarah",
            "description": "Se você quer romance, chame um escocês.",
            "price": "26.50"
        }');

        $this->assertEquals('406', $client->getResponse()->getStatusCode());
    }

    public function testGetBookShouldReturn401()
    {
        $client = $this->createClient(array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'abc',
            'HTTP_Accept' => 'application/json',
        ));

        $client->request('GET', '/book', [], [], [], '{}');

        $this->assertEquals('401', $client->getResponse()->getStatusCode());
    }

    public function testGetBook()
    {
        $client = $this->createClient(array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => '456',
            'HTTP_Accept' => 'application/json',
        ));

        $client->request('GET', '/book');

        $this->assertEquals('200', $client->getResponse()->getStatusCode());
        $collection = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('application/json', $client->getResponse()->headers->get('Content-Type'));
        $this->assertCount(2, $collection);
    }

    public function testDeleteBookShouldReturn401()
    {
        $client = $this->createClient(array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'abc',
            'HTTP_Accept' => 'application/json',
        ));

        $client->request('DELETE', '/book/4DB2E160-30BA-42D6-9CB3-7F5B946E966B');

        $this->assertEquals('401', $client->getResponse()->getStatusCode());
    }

    public function testDeleteBook()
    {
        $client = $this->createClient(array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => '456',
            'HTTP_Accept' => 'application/json',
        ));

        $client->request('DELETE', '/book/4DB2E160-30BA-42D6-9CB3-7F5B946E966B');

        $this->assertEquals('200', $client->getResponse()->getStatusCode());
        $this->assertEquals('application/json', $client->getResponse()->headers->get('Content-Type'));
    }

    public function testDeleteShouldReturn404()
    {
        $client = $this->createClient(array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => '456',
            'HTTP_Accept' => 'application/json',
        ));

        $client->request('DELETE', '/book/4DB2E16');

        $this->assertEquals('404', $client->getResponse()->getStatusCode());
    }

    public function testDeleteShouldReturn406WhenAcceptIsHtml()
    {
        $client = $this->createClient(array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => '456',
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'text/html',

        ));

        $client->request('DELETE', '/book/3DB2E160-30BA-42D6-9CB3-7F5B946E966C');

        $this->assertEquals('406', $client->getResponse()->getStatusCode());
    }

    public function createApplication()
    {
        $app = require __DIR__ . '/../src/app.php';
        require __DIR__ . '/../config/test.php';
        require __DIR__ . '/../src/controllers.php';

        return $this->app = $app;
    }
}
