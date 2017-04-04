<?php

namespace Entity;

use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /**
     * @var Product
     */
    private $product;

    public function setUp()
    {
        $this->product = new Product();
    }

    /**
     * @dataProvider nameProvider
     * @param string $name
     */
    public function testName($name)
    {
        $this->product->setName($name);
        $this->assertEquals($name, $this->product->getName());
    }

    public static function nameProvider()
    {
        return [
            ['Product XYZ'],
            ['New Product'],
            ['Another Product']
        ];
    }

    /**
     * @dataProvider descriptionProvider
     * @param string $description
     */
    public function testDescription($description)
    {
        $this->product->setDescription($description);
        $this->assertEquals($description, $this->product->getDescription());
    }

    public static function descriptionProvider()
    {
        return [
            ['The product is beatiful'],
            ['Big product'],
            ['Old and fancy product']
        ];
    }

    /**
     * @dataProvider priceProvider
     * @param string $price
     */
    public function testPrice($price)
    {
        $this->product->setPrice($price);
        $this->assertEquals($price, $this->product->getPrice());
    }

    public static function priceProvider()
    {
        return [
            [89089.1],
            [345],
            [987.45],
            [23]
        ];
    }

    /**
     * @dataProvider weightProvider
     * @param string $weight
     */
    public function testWeight($weight)
    {
        $this->product->setWeight($weight);
        $this->assertEquals($weight, $this->product->getWeight());
    }

    public static function weightProvider()
    {
        return [
            [234.34],
            [67],
            [82882],
            [6576.9]
        ];
    }

    /**
     * @dataProvider activeProvider
     * @param string $active
     */
    public function testActive($active)
    {
        $this->product->setActive($active);
        $this->assertEquals($active, $this->product->isActive());
    }

    public static function activeProvider()
    {
        return [
            [true],
            [false]
        ];
    }
}
