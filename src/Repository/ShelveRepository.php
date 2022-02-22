<?php

namespace App\Repository;

use App\Entity\Shelve;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Shelve|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shelve|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shelve[]    findAll()
 * @method Shelve[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShelveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shelve::class);
    }

     /**
     * @return Shelve[] Returns an array of Shelve objects
    **/

    public function getUserBooksFromShelve(int $userId, string $shelve)
    {
        return $this->createQueryBuilder('s')
            ->select('IDENTITY(s.user)', 'IDENTITY(s.book)')
            ->where('s.status = :shelve')
            ->andWhere('s.user = :userId')
            ->setParameter('shelve', $shelve)
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult()
        ;
    }
}
