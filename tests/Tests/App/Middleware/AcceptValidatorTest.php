<?php

namespace Test\App\Middleware;

use App\Middleware\AcceptValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AcceptValidatorTest extends TestCase
{
    /**
     * @param $headers
     * @param $constraint
     * @dataProvider headerDataProvider
     */
    public function testValidator($headers, $constraint)
    {
        $request = new Request();
        $request->headers->set('accept', $headers);

        $validator = new AcceptValidator();
        $value = $validator($request);

        $this->assertThat($value, $constraint);
    }

    public function headerDataProvider()
    {
        return array(
            array(
                'headers' => array('*/*'),
                'expectedResult' => $this->isNull()
            ),
            array(
                'headers' => array('application/json'),
                'expectedResult' => $this->isNull()
            ),
            array(
                'headers' => array('*/*', 'application/json'),
                'expectedResult' => $this->isNull()
            ),
            array(
                'headers' => array('*/*', 'text/html'),
                'expectedResult' => $this->isNull()
            ),
            array(
                'headers' => array('application/json', 'text/html'),
                'expectedResult' => $this->isNull()
            ),
            array(
                'headers' => null,
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