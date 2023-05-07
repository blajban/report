<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
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

    private function getMethod(string $type, string $attribute, Book $object): string
    {
        $method = $type . ucfirst($attribute);
        if (method_exists($object, $method)) {
            return $method;
        }

        throw new Exception('Method does not exist');
    }

    /**
     * @param array<string, mixed> $arr
     * @return void
     */
    private function process(Book $obj, array $arr)
    {
        foreach ($arr as $key => $value) {
            if ($value) {
                $method = $this->getMethod('set', $key, $obj);
                $obj->$method($value);
            }
        }

        $this->save($obj, true);
    }

    /**
     * @param array<string, mixed> $arr
     * @return void
     */
    public function add(Book $book, array $arr)
    {
        $this->process($book, $arr);
    }

    /**
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @param array<string, mixed> $arr
     * @return void
     */
    public function update(int $id, array $arr)
    {
        $book = $this->find($id);

        if (!$book) {
            throw new Exception('Found no book with '.$id);
        }

        $this->process($book, $arr);
    }

    /**
     * @param array<int> $ids
     * @return array<?Book>
     */
    public function findManybyId(array $ids): array
    {
        $res = [];
        foreach ($ids as $id) {
            $res[] = $this->find($id);
        }

        return $res;
    }

    /**
     * @param array<int> $ids
     * @return void
     */
    public function delete(array $ids)
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

    public function findOnebyIsbn(string $isbn): ?Book
    {
        /** @var Book|null $res */
        $res = $this->createQueryBuilder('b')
            ->andWhere('b.isbn = :val')
            ->setParameter('val', $isbn)
            ->getQuery()
            ->getOneOrNullResult();

        return $res;
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
