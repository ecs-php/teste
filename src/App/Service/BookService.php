<?php
namespace App\Service;

use App\Entity\Book;
use App\Exception\BookNotFoundException;
use App\Exception\BookServiceException;
use Doctrine\ORM\EntityManagerInterface;

class BookService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Book $param
     * @return Book
     * @throws BookServiceException
     */
    public function create(Book $param)
    {
        try {
            $book = new Book();
            $now = new \DateTime();

            $this->setParam($book, $param);
            $book->setCreatedAt($now);
            $book->setUpdatedAt($now);

            $this->entityManager->persist($book);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new BookServiceException('Some inconsistence on create', null, $e);
        }

        return $book;
    }

    /**
     * @param $id
     * @param Book $param
     * @return object
     * @throws BookNotFoundException
     * @throws BookServiceException
     */
    public function update($id, Book $param)
    {
        try {
            $book = $this->entityManager->find(Book::class, $id);

            if (empty($book)) {
                throw new BookNotFoundException($id);
            }

            $now = new \DateTime();

            $this->setParam($book, $param);
            $book->setUpdatedAt($now);

            $this->entityManager->persist($book);
            $this->entityManager->flush();
        } catch (BookNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new BookServiceException('Some inconsistence on create', null, $e);
        }

        return $book;
    }

    /**
     * @param $id
     * @return mixed
     * @throws BookNotFoundException
     * @throws BookServiceException
     */
    public function delete($id)
    {
        try {
            $book = $this->entityManager->find(Book::class, $id);

            if (empty($book)) {
                throw new BookNotFoundException($id);
            }

            $this->entityManager->remove($book);
            $this->entityManager->flush();
        } catch (BookNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new BookServiceException('Some inconsistence on create', null, $e);
        }

        return $book;
    }

   private function setParam(Book $book, Book $param)
    {
        if ($param->getIsbn()) {
            $book->setIsbn($param->getIsbn());
        }

        if ($param->getTitle()) {
            $book->setTitle($param->getTitle());
        }

        if ($param->getAuthor()) {
            $book->setAuthor($param->getAuthor());
        }

        if ($param->getDescription()) {
            $book->setDescription($param->getDescription());
        }

        if ($param->getDescription()) {
            $book->setPrice($param->getPrice());
        }
    }
}