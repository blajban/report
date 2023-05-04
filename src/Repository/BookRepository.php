<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    private function getMethod($type, $attribute, $object)
    {
        $method = $type . ucfirst($attribute);
        if (method_exists($object, $method)) {
            return $method;
        }

        throw new Exception('Method does not exist');
    }

    private function process($obj, $arr)
    {
        foreach ($arr as $key => $value) {
            if ($value) {
                $method = $this->getMethod('set', $key, $obj);
                $obj->$method($value);
            }
        }

        $this->save($obj, true);
    }

    public function add($book, $arr)
    {
        $this->process($book, $arr);
    }

    public function update($id, $arr)
    {
        $book = $this->find($id);

        if (!$book) {
            throw new Exception('Found no book with '.$id);
        }

        $this->process($book, $arr);
    }

    public function findManybyId($ids): array
    {
        $res = [];
        foreach ($ids as $id) {
            $res[] = $this->find($id);
        }

        return $res;
    }
    
    public function delete($ids)
    {
        foreach ($ids as $id) {
            $book = $this->find($id);

            if (!$book) {
                throw new Exception('Found no book with '.$id);
            }

            $this->getEntityManager()->remove($book);
        }

        $this->getEntityManager()->flush();
    }

    public function save(Book $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Book $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
