<?php

namespace App\Converter;

use App\Entity\Book;
use App\Exception\BookConverterException;
use App\Exception\BookNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class BookConverter
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke($id)
    {
        return $this->converter($id);
    }

    /**
     * @param $id
     * @return object
     * @throws BookConverterException|BookNotFoundException
     */
    public function converter($id)
    {
        try {
            $book = $this->entityManager->find(Book::class, $id);
        } catch (\Exception $e) {
            throw new BookConverterException($e);
        }

        if (!$book instanceof Book) {
            throw new BookNotFoundException($id);
        }

        return $book;
    }
}