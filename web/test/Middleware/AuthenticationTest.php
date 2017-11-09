<?php
namespace Hmarinjr\RESTFulAPI\Middleware;

use App\Acme\Foo;
use PHPUnit\Framework\TestCase;

class BooksRepositoryTest extends TestCase
{
	/**
	 * @test
	 */
	public function theClassAuthenticationHaveToExist()
	{
		$this->assertInstanceOf('Hmarinjr\RESTFulAPI\Middleware\Authentication', new Authentication());
	}
}
