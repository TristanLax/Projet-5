<?php

namespace App\Repository;

use App\Entity\Post;
use App\Entity\PostReports;
use App\Entity\PostVotes;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }


    public function countVotes()
    {
        return $this->createQueryBuilder('p')
            ->innerJoin(PostVotes::class, 'pv', Join::WITH, 'pv.post = p.id')
            ->select('COUNT(p.id) AS nbVotes', 'p AS post')
            ->groupBy('p.id')
            ->orderBy('nbVotes', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();


    }

    public function countReports()
    {
        return $this->createQueryBuilder('p')
            ->innerJoin(PostReports::class, 'pr', JOIN::WITH, 'pr.post = p.id')
            ->select('COUNT(p.id) AS nbReport ', 'p AS post')
            ->groupBy('p.id')
            ->orderBy('nbReport', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function countPosts($user)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin(User::class, 'u', JOIN::WITH, 'u.id = p.author')
            ->select('COUNT(p.author) AS nbPosts')
            ->andWhere('u.id = (:user)')
            ->setParameter(':user', $user)
            ->groupBy('p.author')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
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
    public function findOneBySomeField($value): ?Post
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
