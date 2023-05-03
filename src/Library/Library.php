<?php

namespace App\Library;

use App\Entity\Book;
use App\Repository\BookRepository;
use Exception;

interface ORMInterface
{
    public function add($arr);
    public function update($id, $arr);
    public function remove($ids);
}

class Library implements ORMInterface
{

    protected BookRepository $repo;

    public function __construct(BookRepository $repo)
    {
        $this->repo = $repo;
    }

    private function getMethod($type, $attribute, $object)
    {
        $method = $type . ucfirst($attribute);
        if (method_exists($object, $method)) {
            return $method;
        }

        throw new Exception('Method does not exist');
    }

    public function add($arr)
    {
        $book = new Book();

        foreach ($arr as $key => $value) {
            $method = $this->getMethod('set', $key, $book);
            $book->$method($value);
        }

        $this->repo->save($book, true);
    }

    public function update($id, $arr)
    {
        $book = $this->repo->find($id);

        if (!$book) {
            throw new Exception('Found no book with '.$id);
        }

        foreach ($arr as $key => $value) {
            $method = $this->getMethod('set', $key, $book);
            $book->$method($value);
        }

        $this->repo->save($book, true);
    }
    
    public function remove($ids)
    {
        foreach ($ids as $id) {
            $book = $this->repo->find($id);

            if (!$book) {
                throw new Exception('Found no book with '.$id);
            }

            $this->repo->remove($book);
        }

        $this->repo->flush();
    }
}
