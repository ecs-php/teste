<?php

namespace Test\App\Middleware;

use App\Middleware\ContentTypeValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentTypeValidatorTest extends TestCase
{
    /**
     * @param $headers
     * @param $constraint
     * @dataProvider headerDataProvider
     */
    public function testValidator($headers, $constraint)
    {
        $request = new Request();
        $request->headers->set('content-type', $headers);

        $validator = new ContentTypeValidator();
        $value = $validator($request);

        $this->assertThat($value, $constraint);
    }

    public function headerDataProvider()
    {
        return array(
            array(
                'headers' => array('*/*'),
                'expectedResult' => $this->isInstanceOf(Response::class)
            ),
            array(
                'headers' => null,
                'expectedResult' => $this->isInstanceOf(Response::class)
            ),
            array(
                'headers' => array('application/json'),
                'expectedResult' => $this->isNull()
            ),
            array(
                'headers' => array('*/*', 'application/json'),
                'expectedResult' => $this->isInstanceOf(Response::class)
            ),
            array(
                'headers' => array('*/*', 'text/html'),
                'expectedResult' => $this->isInstanceOf(Response::class)
            ),
            array(
                'headers' => array('application/json', 'text/html'),
                'expectedResult' => $this->isInstanceOf(Response::class)
            ),
            array(
                'headers' => array('text/html'),
                'expectedResult' => $this->isInstanceOf(Response::class)
            ),
            array(
                'headers' => array('text/html', 'text/csv'),
                'expectedResult' => $this->isInstanceOf(Response::class)
            ),
        );
    }
}