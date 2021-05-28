<?php

namespace App\Repository;

use App\Entity\Jouet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Jouet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jouet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jouet[]    findAll()
 * @method Jouet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JouetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Jouet::class);
    }
    /**
     * @return Jouet[]
     */
    public function Req1()
    {
        return $this->getEntityManager()->createQuery(
            "SELECT j.des_jouet FROM App\Entity\Jouet j 
            WHERE j.qte_stock_jouet = (SELECT MAX(jj.qte_stock_jouet) from App\Entity\Jouet jj)       
          "
        )->getResult();
    }
    public function Req2()
    {
        return $this->getEntityManager()->createQuery(
            "SELECT j.des_jouet FROM App\Entity\Jouet j
            WHERE j.code_four_jouet =  3     
          "
        )->getResult();
    }
    public function Req3()
    {
        return $this->getEntityManager()->createQuery(
            "SELECT j.des_jouet FROM App\Entity\Jouet j 
            WHERE j.PU_jouet = (SELECT MIN(jj.PU_jouet) from App\Entity\Jouet jj)       
          "
        )->getResult();
    }
    public function Req5(){
        $queryBuilder = $this->createQueryBuilder('j');
$queryBuilder->update()
    ->set('j.PU_jouet', 'j.PU_jouet+10')
    ->where('j.code_four_jouet = 2')
    ->getQuery()
    ->execute();
    }
    public function Req6(){
        $queryBuilder = $this->createQueryBuilder('j');
$queryBuilder->delete()
    ->where('j.code_four_jouet = 3')
    ->getQuery()
    ->execute();
    }


    // /**
    //  * @return Jouet[] Returns an array of Jouet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Jouet
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
