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

    private const BOOK_ID_ALIAS = "bookId";
    private const MAX_RESULTS_IN_QUICK_SEARCH = 8;

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
                    b.title 
                FROM books b
                JOIN book_author ba 
                    ON (ba.book_id = b.id)
                JOIN authors a
                    ON (ba.author_id = a.id)
                WHERE b.title LIKE :name
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['name' => sprintf("%%%s%%", $title)]);

       return $resultSet->fetchAllAssociative();
    }

    public function getBookAuthor($searchTerm) {

        $qb = $this->createQueryBuilder('b');

            $qb->select('b.id AS ' . self::BOOK_ID_ALIAS)
                ->addSelect('b.title')
                ->addSelect('a.firstName')
                ->addSelect('a.lastName')
                ->join('App\Entity\BookAuthor', 'ba', 'WITH', 'b.id = ba.bookId')
                ->join('App\Entity\Author', 'a', 'WITH', 'a.id = ba.authorId')
                ->where($qb->expr()->like('a.firstName', ':searchTerm'))
                ->orWhere($qb->expr()->like('a.lastName', ':searchTerm'))
                ->orWhere($qb->expr()->like('b.title', ':searchTerm'))
                ->setParameter('searchTerm', sprintf("%%%s%%", $searchTerm))
                ->setMaxResults(self::MAX_RESULTS_IN_QUICK_SEARCH);

                $result = $qb
                ->getQuery()
            ->getArrayResult()
                ;

        return $result;
    //     $stmt = $conn->prepare($sql);
    //     $resultSet = $stmt->executeQuery(['name' => sprintf("%%%s%%", $searchTerm)]);

    //    return $resultSet->fetchAllAssociative();
    }
}
