<?php

namespace App\Repository;

use App\Entity\CommentReports;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CommentReports|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentReports|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentReports[]    findAll()
 * @method CommentReports[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentReportsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CommentReports::class);
    }

    // /**
    //  * @return CommentReports[] Returns an array of CommentReports objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CommentReports
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
