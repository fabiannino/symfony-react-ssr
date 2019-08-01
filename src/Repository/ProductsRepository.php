<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Products::class);
    }

    public function getNextSort (): int {
        $nextSort = $this->createQueryBuilder('p')
            ->select('MAX(p.sort) as max_sort')
            ->getQuery()
            ->getOneOrNullResult()
            ;
        return $nextSort['max_sort']+1;
    }

    public function findByLink($value) : ?Products {
        $now = new \DateTime();
        return $this->createQueryBuilder('p')
            ->where('p.link = :link')
            // ->andWhere('p.status=1')
            // ->andWhere('p.date_available >= :now')
            ->setParameter('link', $value)
            // ->setParameter('now', $now->format('Y-m-d'))
            ->getQuery()
            ->getOneOrNullResult();
    }


    // /**
    //  * @return Products[] Returns an array of Products objects
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
    public function findOneBySomeField($value): ?Products
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
