<?php

namespace App\Repository;

use App\Entity\Operation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Operation>
 */
class OperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Operation::class);
    }

    public function findByStatus(string $value): array
    {
        return $this->createQueryBuilder('o')
            ->join('o.client', 'c')
            ->andWhere('o.status = :val')
            ->setParameter('val', $value)
            ->orderBy('c.nom', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findOneByClientName(string $clientName): array
    {
        return $this->createQueryBuilder('o')
            ->join('o.client', 'c')
            ->where('c.nom LIKE :clientName')
            ->setParameter('clientName', '%' . $clientName . '%')
            ->getQuery()
            ->getResult();
    }
}

