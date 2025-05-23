<?php

namespace App\Repository;

use App\Entity\Office;
use App\Entity\OfficeTypeOfService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<OfficeTypeOfService>
 */
class OfficeTypeOfServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OfficeTypeOfService::class);
    }

    public function findByOffice(Office $office): array
{
    return $this->createQueryBuilder('ots')
        ->join('ots.office', 'o')
        ->where(':office MEMBER OF ots.office')
        ->setParameter('office', $office)
        ->getQuery()
        ->getResult();
}

    //    /**
    //     * @return OfficeTypeOfService[] Returns an array of OfficeTypeOfService objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?OfficeTypeOfService
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
