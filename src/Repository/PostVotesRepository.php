<?php

namespace App\Repository;

use App\Entity\PostVotes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PostVotes|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostVotes|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostVotes[]    findAll()
 * @method PostVotes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostVotesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PostVotes::class);
    }

    // /**
    //  * @return PostVotes[] Returns an array of PostVotes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PostVotes
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
