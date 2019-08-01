<?php

namespace App\Repository;

use App\Entity\ProductSkus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductSkus|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductSkus|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductSkus[]    findAll()
 * @method ProductSkus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductSkusRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductSkus::class);
    }

    public function findBySku($value) : ?ProductSkus {
        $now = new \DateTime();
        return $this->createQueryBuilder('p')
            ->where('p.sku = :sku')
            ->andWhere('p.status=1')
            ->andWhere('p.date_available >= :now')
            ->setParameter('sku', $value)
            ->setParameter('now', $now->format('Y-m-d'))
            ->getQuery()
            ->getOneOrNullResult();
    }

    // public function findByProductId($productId) : ?ProductSkus {
    //     return $this->createQueryBuilder('s')
    //         ->where('s.products = :productId')
    //         ->setParameter('productId', $productId)
    //         ->getQuery()
    //         ->getResult();
    // }


    // /**
    //  * @return ProductSkus[] Returns an array of ProductSkus objects
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
    public function findOneBySomeField($value): ?ProductSkus
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
