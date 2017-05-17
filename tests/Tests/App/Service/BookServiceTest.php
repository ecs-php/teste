<?php

namespace Test\App\Service;

use App\Service\BookService;
use App\Entity\Book;
use PHPUnit\Framework\TestCase;

class BookServiceTest extends TestCase
{
    public function testShouldCreate()
    {
        $param = $this->createBook();

        $entityManager = $this->getMockBuilder(\Doctrine\ORM\EntityManagerInterface::class)
            ->getMockForAbstractClass();

        $entityManager->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Book::class));

        $entityManager->expects($this->once())
            ->method('flush');

        $bookService = new BookService($entityManager);

        $book = $bookService->create($param);

        $this->assertInstanceOf(Book::class, $book);
        $this->assertEquals('97821234568039', $book->getIsbn());
        $this->assertEquals('Juliana Dantas', $book->getAuthor());
        $this->assertEquals('Thomas e Liz se conheceram e viveram uma paixão intensa que não acabou nada bem.',
            $book->getDescription());
        $this->assertEquals('7.99', $book->getPrice());
        $this->assertInstanceOf(\DateTime::class, $book->getCreatedAt());
        $this->assertInstanceOf(\DateTime::class, $book->getUpdatedAt());
        $this->assertEquals($book->getCreatedAt(), $book->getUpdatedAt());
    }

    public function testCreateShouldIgnoreCreatedAtAndUpdateAt()
    {
        $dateTimeToIgnore = new \DateTime('1970-01-01');

        $param = $this->createBook();
        $param->setCreatedAt($dateTimeToIgnore);
        $param->setUpdatedAt($dateTimeToIgnore);

        $entityManager = $this->getMockBuilder(\Doctrine\ORM\EntityManagerInterface::class)
            ->getMockForAbstractClass();

        $entityManager->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Book::class));

        $entityManager->expects($this->once())
            ->method('flush');

        $bookService = new BookService($entityManager);
        $book = $bookService->create($param);

        $this->assertInstanceOf(\DateTime::class, $book->getCreatedAt());
        $this->assertInstanceOf(\DateTime::class, $book->getUpdatedAt());
        $this->assertEquals($book->getCreatedAt(), $book->getUpdatedAt());
        $this->assertNotEquals($dateTimeToIgnore, $book->getCreatedAt());
        $this->assertNotEquals($dateTimeToIgnore, $book->getUpdatedAt());
    }

    /**
     * @expectedException \App\Exception\BookServiceException
     */
    public function testCreateShouldWrapAnyException()
    {
        $dateTimeToIgnore = new \DateTime('1970-01-01');

        $param = $this->createBook();
        $param->setCreatedAt($dateTimeToIgnore);
        $param->setUpdatedAt($dateTimeToIgnore);

        $entityManager = $this->getMockBuilder(\Doctrine\ORM\EntityManagerInterface::class)
            ->getMockForAbstractClass();

        $entityManager->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf($param));

        $entityManager->expects($this->once())
            ->method('flush')
            ->willThrowException(new \Exception('some exception'));

        $bookService = new BookService($entityManager);
        $bookService->create($param);
    }

    public function testShouldUpdate()
    {
        $id = '12312312315456456';

        $param = $this->createBook2();

        $book = $this->createBook();
        $book->setCreatedAt(new \DateTime('1972-01-01'));
        $book->setUpdatedAt(new \DateTime('1972-01-01'));


        $entityManager = $this->getMockBuilder(\Doctrine\ORM\EntityManagerInterface::class)
            ->getMockForAbstractClass();

        $entityManager->expects($this->once())
            ->method('find')
            ->with(Book::class, $id)
            ->willReturn($book);

        $entityManager->expects($this->once())
            ->method('flush');

        $bookService = new BookService($entityManager);
        $return = $bookService->update($id, $param);

        $this->assertEquals($return, $book);
        $this->assertEquals('978-8542200188', $book->getIsbn());
        $this->assertEquals('A Verdade por Trás do Google', $book->getTitle());
        $this->assertEquals('Alejandro Suárez Sánchez Ocaña', $book->getAuthor());
        $this->assertEquals('Quais são as verdadeiras intenções do Google?',
            $book->getDescription());
        $this->assertEquals('4.90', $book->getPrice());
        $this->assertInstanceOf(\DateTime::class, $book->getCreatedAt());
        $this->assertInstanceOf(\DateTime::class, $book->getUpdatedAt());
        $this->assertNotEquals($book->getCreatedAt(), $book->getUpdatedAt());
    }

    public function testShouldUpdateOneFields()
    {
        $id = '12312312315456456';

        $param = new Book();
        $param->setTitle('Amor Para Um Escocês');

        $book = $this->createBook2();
        $book->setCreatedAt(new \DateTime('1972-01-01'));
        $book->setUpdatedAt(new \DateTime('1972-01-01'));


        $entityManager = $this->getMockBuilder(\Doctrine\ORM\EntityManagerInterface::class)
            ->getMockForAbstractClass();

        $entityManager->expects($this->once())
            ->method('find')
            ->with(Book::class, $id)
            ->willReturn($book);

        $entityManager->expects($this->once())
            ->method('flush');

        $bookService = new BookService($entityManager);
        $return = $bookService->update($id, $param);

        $this->assertEquals($return, $book);
        $this->assertEquals('978-8542200188', $book->getIsbn());
        $this->assertEquals('Amor Para Um Escocês', $book->getTitle());
        $this->assertEquals('Alejandro Suárez Sánchez Ocaña', $book->getAuthor());
        $this->assertEquals('Quais são as verdadeiras intenções do Google?',
            $book->getDescription());
        $this->assertEquals('4.90', $book->getPrice());
        $this->assertInstanceOf(\DateTime::class, $book->getCreatedAt());
        $this->assertInstanceOf(\DateTime::class, $book->getUpdatedAt());
        $this->assertNotEquals($book->getCreatedAt(), $book->getUpdatedAt());
    }

    /**
     * @expectedException \App\Exception\BookServiceException
     */
    public function testUpdateShouldThrowBookServiceException()
    {
        $id = '12312312315456456';

        $param = $this->createBook2();

        $book = $this->createBook();
        $book->setCreatedAt(new \DateTime('1972-01-01'));
        $book->setUpdatedAt(new \DateTime('1972-01-01'));


        $entityManager = $this->getMockBuilder(\Doctrine\ORM\EntityManagerInterface::class)
            ->getMockForAbstractClass();

        $entityManager->expects($this->once())
            ->method('find')
            ->with(Book::class, $id)
            ->willReturn($book);

        $entityManager->expects($this->once())
            ->method('flush')
            ->willThrowException(new \Exception('some exception'));

        $bookService = new BookService($entityManager);
        $bookService->update($id, $param);
    }

    public function testShouldDelete()
    {
        $id = '12312312315456456';

        $book = $this->createBook();

        $entityManager = $this->getMockBuilder(\Doctrine\ORM\EntityManagerInterface::class)
            ->getMockForAbstractClass();

        $entityManager->expects($this->once())
            ->method('find')
            ->with(Book::class, $id)
            ->willReturn($book);

        $entityManager->expects($this->once())
            ->method('remove')
            ->with($book);

        $entityManager->expects($this->once())
            ->method('flush');

        $bookService = new BookService($entityManager);

        $return = $bookService->delete($id);

        $this->assertEquals($book, $return);
    }

    /**
     * @expectedException \App\Exception\BookServiceException
     */
    public function testDeleteShouldThrowBookServiceException()
    {
        $id = '12312312315456456';

        $book = $this->createBook();

        $entityManager = $this->getMockBuilder(\Doctrine\ORM\EntityManagerInterface::class)
            ->getMockForAbstractClass();

        $entityManager->expects($this->once())
            ->method('find')
            ->with(Book::class, $id)
            ->willReturn($book);

        $entityManager->expects($this->once())
            ->method('remove')
            ->with($book);

        $entityManager->expects($this->once())
            ->method('flush')
            ->willThrowException(new \Exception('some exception'));

        $bookService = new BookService($entityManager);

        $bookService->delete($id);
    }

    /**
     * @return Book
     */
    public function createBook()
    {
        $book = new \App\Entity\Book();
        $book->setIsbn('97821234568039');
        $book->setTitle('Linha da Vida');
        $book->setAuthor('Juliana Dantas');
        $book->setDescription('Thomas e Liz se conheceram e viveram uma paixão intensa que não acabou nada bem.');
        $book->setPrice('7.99');

        return $book;
    }

    /**
     * @return Book
     */
    public function createBook2()
    {
        $book = new \App\Entity\Book();
        $book->setIsbn('978-8542200188');
        $book->setTitle('A Verdade por Trás do Google');
        $book->setAuthor('Alejandro Suárez Sánchez Ocaña');
        $book->setDescription('Quais são as verdadeiras intenções do Google?');
        $book->setPrice('4.90');

        return $book;
    }

}