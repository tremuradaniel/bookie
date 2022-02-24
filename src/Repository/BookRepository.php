<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
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

   /**
      * @return Books[] Returns an array of books
    */
    public function findBooksByTitle($title)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
                SELECT 
                    a.first_name,
                    a.last_name,
                    b.name as title 
                FROM books b
                JOIN authors a 
                ON (b.author_id = a.id)
                WHERE b.name LIKE :name
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['name' => sprintf("%%%s%%", $title)]);

        // returns an array of arrays (i.e. a raw data set)

        // return 
       return $resultSet->fetchAllAssociative();

    }

    /*
    public function findOneBySomeField($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
