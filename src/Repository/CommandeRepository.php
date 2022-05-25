<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Commande $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Commande $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
    * @return Commande[] Returns an array of Commande objects
    */
    
    public function findByYear($month, $year)
    {
        $startDate = \DateTime::createFromFormat('d-n-Y', "01-".$month."-".$year);
        $startDate->setTime(0, 0 ,0);

        $endDate = \DateTime::createFromFormat('d-n-Y', "31-".$month."-".$year);
        $endDate->setTime(0, 0, 0);

        return $this->createQueryBuilder('c')
            ->select('count(c.id)')
            ->andWhere('c.dateCommande BETWEEN :start AND :end')
            ->setParameter(':start', $startDate)
            ->setParameter(':end', $endDate)
            ->getQuery()
            ->getResult();
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Commande
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
