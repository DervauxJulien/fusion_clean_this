<?php

namespace App\Repository;

use App\Entity\Operation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Operation>
 *
 * @method Operation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Operation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Operation[]    findAll()
 * @method Operation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Operation::class);
    }

//    /**
//     * @return Operation[] Returns an array of Operation objects
//     */
   public function findByStatus($value): array
   {
       return $this->createQueryBuilder('o')
           ->andWhere('o.status = :val')
           ->setParameter('val', $value)
           ->orderBy('o.date_demande', 'ASC')
           ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }

   public function OperationEnCours(int $userId) : int
   {
    return $this->createQueryBuilder('o')
        ->select('count(o.id)')
        ->where('o.user = :user')
        ->andWhere('o.status = :status')
        ->setParameter('user', $userId)
        ->setParameter('status', 'En cours')
        ->getQuery()
        ->getSingleScalarResult()
        ;
   }

//    public function findOneBySomeField($value): ?Operation
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
