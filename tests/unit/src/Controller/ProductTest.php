<?php

namespace Controller;

use AbstractControllerTest;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Response;

class ProductTest extends AbstractControllerTest
{
    public function testIndexUnauthorized()
    {
        try {
            $this->client->get('/products');
        } catch (RequestException $e) {
            $this->assertEquals(Response::HTTP_UNAUTHORIZED, $e->getCode());
        }
    }

    public function testShowUnauthorized()
    {
        try {
            $this->client->get('/products/1');
        } catch (RequestException $e) {
            $this->assertEquals(Response::HTTP_UNAUTHORIZED, $e->getCode());
        }
    }

    public function testCreateUnauthorized()
    {
        try {
            $this->client->post('/products');
        } catch (RequestException $e) {
            $this->assertEquals(Response::HTTP_UNAUTHORIZED, $e->getCode());
        }
    }

    public function testUpdateUnauthorized()
    {
        try {
            $this->client->put('/products/1');
        } catch (RequestException $e) {
            $this->assertEquals(Response::HTTP_UNAUTHORIZED, $e->getCode());
        }
    }

    public function testDestroyUnauthorized()
    {
        try {
            $this->client->delete('/products/1');
        } catch (RequestException $e) {
            $this->assertEquals(Response::HTTP_UNAUTHORIZED, $e->getCode());
        }
    }

    public function testIndexSuccess()
    {
        $response = $this->client->get('/products', $this->getRequestOptions());
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaders()['Content-Type'][0]);
    }

    public function testShowNotFound()
    {
        try {
            $this->client->get('/products/inexistent-id', $this->getRequestOptions());
        } catch (RequestException $e) {
            $this->assertEquals(Response::HTTP_NOT_FOUND, $e->getCode());
            $this->assertEquals('application/json', $e->getRequest()->getHeaders()['Content-Type'][0]);
        }
    }

    /**
     * @dataProvider validProductProvider
     * @param string $name
     * @param string $description
     * @param float $price
     * @param float $weight
     * @param boolean $active
     */
    public function testShowSuccess($name, $description, $price, $weight, $active)
    {
        // Create product
        $body = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'weight' => $weight,
            'active' => $active
        ];
        $response = $this->client->post('/products', $this->getRequestOptions($body));
        $data = json_decode($response->getBody(), true);

        // Test show
        $response = $this->client->get('/products/' . $data['id'], $this->getRequestOptions());
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaders()['Content-Type'][0]);
        $data = json_decode($response->getBody(), true);

        $this->checkProductData($body, $data);

        // Delete product
        $this->client->delete('/products/' . $data['id'], $this->getRequestOptions());
    }

    /**
     * @dataProvider validProductProvider
     * @param string $name
     * @param string $description
     * @param float $price
     * @param float $weight
     * @param boolean $active
     */
    public function testCreateSuccess($name, $description, $price, $weight, $active)
    {
        // Create product
        $body = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'weight' => $weight,
            'active' => $active
        ];
        $response = $this->client->post('/products', $this->getRequestOptions($body));

        // Assert response
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaders()['Content-Type'][0]);
        $data = json_decode($response->getBody(), true);

        $this->checkProductData($body, $data);

        // Delete product
        $this->client->delete('/products/' . $data['id'], $this->getRequestOptions());
    }

    public function testUpdateNotFound()
    {
        try {
            $this->client->put('/products/inexistent-id', $this->getRequestOptions());
        } catch (RequestException $e) {
            $this->assertEquals(Response::HTTP_NOT_FOUND, $e->getCode());
            $this->assertEquals('application/json', $e->getRequest()->getHeaders()['Content-Type'][0]);
        }
    }

    /**
     * @dataProvider validProductProvider
     * @param string $name
     * @param string $description
     * @param float $price
     * @param float $weight
     * @param boolean $active
     */
    public function testUpdateSuccess($name, $description, $price, $weight, $active)
    {
        // Create product
        $body = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'weight' => $weight,
            'active' => $active
        ];
        $response = $this->client->post('/products', $this->getRequestOptions($body));
        $data = json_decode($response->getBody(), true);

        // Update product
        $newBody = [
            'name' => 'Product new name',
            'description' => 'Product new description',
            'price' => 99.888,
            'weight' => 45.56,
            'active' => false
        ];
        $response = $this->client->put('/products/' . $data['id'], $this->getRequestOptions($newBody));
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaders()['Content-Type'][0]);
        $data = json_decode($response->getBody(), true);

        $this->checkProductData($newBody, $data);

        // Delete product
        $this->client->delete('/products/' . $data['id'], $this->getRequestOptions());
    }

    public function testDeleteNotFound()
    {
        try {
            $this->client->delete('/products/inexistent-id', $this->getRequestOptions());
        } catch (RequestException $e) {
            $this->assertEquals(Response::HTTP_NOT_FOUND, $e->getCode());
            $this->assertEquals('application/json', $e->getRequest()->getHeaders()['Content-Type'][0]);
        }
    }

    /**
     * @dataProvider validProductProvider
     * @param string $name
     * @param string $description
     * @param float $price
     * @param float $weight
     * @param boolean $active
     */
    public function testDeleteSuccess($name, $description, $price, $weight, $active)
    {
        // Create product
        $body = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'weight' => $weight,
            'active' => $active
        ];
        $response = $this->client->post('/products', $this->getRequestOptions($body));
        $data = json_decode($response->getBody(), true);

        // Try to delete
        $response = $this->client->delete('/products/' . $data['id'], $this->getRequestOptions());
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    private function checkProductData(array $body, array $data)
    {
        // Check array keys
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('description', $data);
        $this->assertArrayHasKey('price', $data);
        $this->assertArrayHasKey('weight', $data);
        $this->assertArrayHasKey('active', $data);
        $this->assertArrayHasKey('createdAt', $data);
        $this->assertArrayHasKey('updatedAt', $data);

        // Check values
        $this->assertEquals($body['name'], $data['name']);
        $this->assertEquals($body['description'], $data['description']);
        $this->assertEquals($body['price'], $data['price']);
        $this->assertEquals($body['weight'], $data['weight']);
        $this->assertEquals($body['active'], $data['active']);
    }

    public static function validProductProvider()
    {
        return [
            ['Product XYZ', 'Big product', 89089.1, 6576.9, true],
            ['New Product', 'The product is beatiful', 345, 82882, true],
            ['Another Product', 'Old and fancy product', 987.45, 234.34, true]
        ];
    }
}
