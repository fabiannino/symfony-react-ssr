<?php

namespace App\Repository;

use App\Entity\Categories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Categories|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categories|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categories[]    findAll()
 * @method Categories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Categories::class);
    }

    public function getNextSort (): int {
        $nextSort = $this->createQueryBuilder('c')
            ->select('MAX(c.sort) as max_sort')
            ->getQuery()
            ->getOneOrNullResult()
            ;
        return $nextSort['max_sort']+1;
    }

    public function findByLink($value) : ?Categories {
        $now = new \DateTime();
        return $this->createQueryBuilder('c')
            ->where('c.link = :link')
            ->andWhere('c.status=1')
            ->andWhere('c.date_available >= :now')
            ->setParameter('link', $value)
            ->setParameter('now', $now->format('Y-m-d'))
            ->getQuery()
            ->getOneOrNullResult();
    }

    // /**
    //  * @return Categories[] Returns an array of Categories objects
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
    public function findOneBySomeField($value): ?Categories
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
