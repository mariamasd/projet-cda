<?php

namespace App\Repository;

use App\Entity\Laborantin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Laborantin>
 *
 * @method Laborantin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Laborantin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Laborantin[]    findAll()
 * @method Laborantin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LaborantinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Laborantin::class);
    }

//    /**
//     * @return Laborantin[] Returns an array of Laborantin objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Laborantin
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
