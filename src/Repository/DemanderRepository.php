<?php

namespace App\Repository;

use App\Entity\Demander;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Demander>
 *
 * @method Demander|null find($id, $lockMode = null, $lockVersion = null)
 * @method Demander|null findOneBy(array $criteria, array $orderBy = null)
 * @method Demander[]    findAll()
 * @method Demander[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemanderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Demander::class);
    }

    //    /**
    //     * @return Demander[] Returns an array of Demander objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Demander
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
