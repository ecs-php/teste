<?php

namespace Test\App\Converter;

use App\Converter\BookConverter;
use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookConverterTest extends TestCase
{
    public function testShouldConvert()
    {
        $entityManager = $this->getMockBuilder(EntityManagerInterface::class)
            ->getMockForAbstractClass();
        $bookConverter = new BookConverter($entityManager);

        $id = '4DB2E160-30BA-42D6-9CB3-7F5B946E966B';

        $entityManager->expects($this->once())
            ->method('find')
            ->with(Book::class, $id)
            ->willReturn(new Book());

        $book = $bookConverter->converter($id);

        $this->assertInstanceOf(Book::class, $book);
    }

    /**
     * @expectedException \App\Exception\BookNotFoundException
     */
    public function testShouldNotFound()
    {
        $entityManager = $this->getMockBuilder(EntityManagerInterface::class)
            ->getMockForAbstractClass();
        $bookConverter = new BookConverter($entityManager);

        $id = '4DB2E160-30BA-42D6-9CB3-7F5B946E966B';

        $entityManager->expects($this->once())
            ->method('find')
            ->with(Book::class, $id)
            ->willReturn(null);

        $bookConverter->converter($id);
    }

    /**
     * @expectedException \App\Exception\BookConverterException
     */
    public function testShouldThrowBookNotFound()
    {
        $entityManager = $this->getMockBuilder(EntityManagerInterface::class)
            ->getMockForAbstractClass();
        $bookConverter = new BookConverter($entityManager);

        $id = '4DB2E160-30BA-42D6-9CB3-7F5B946E966B';

        $entityManager->expects($this->once())
            ->method('find')
            ->with(Book::class, $id)
            ->willThrowException(new \Exception());

        $bookConverter->converter($id);
    }

}