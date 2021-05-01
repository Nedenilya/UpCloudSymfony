<?php

namespace App\Repository;

use App\Entity\Uploads;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Uploads|null find($id, $lockMode = null, $lockVersion = null)
 * @method Uploads|null findOneBy(array $criteria, array $orderBy = null)
 * @method Uploads[]    findAll()
 * @method Uploads[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UploadsRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Uploads::class);
    }

    /**
     * @return integer
     */
    public function findAllSize($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT SUM(e.size)
            FROM App\Entity\Uploads e
            WHERE e.userid='.$id
        );

        return $query->getResult()[0][1];
    }  

    /**
     * @return Uploads Return Uploads object
     */
    public function findById($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT e
            FROM App\Entity\Uploads e
            WHERE e.id = '.$id
        );

        return $query->getResult();
    }

    public function findAll2($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT e
            FROM App\Entity\Uploads e
            WHERE e.isarchived=false AND e.userid='.$id
        );

        return $query->getResult();
    }

    public function getFileNameById($id){
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT e.hashName
            FROM App\Entity\Uploads e
            WHERE e.id = '.$id
        );

        return $query->getResult();
    }

    public function findByTitle($title, $id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT e
            FROM App\Entity\Uploads e
            WHERE e.userid='.$id.' AND e.isarchived=false AND e.fileName LIKE \''.$title.'%\''
        );

        return $query->getResult();
    }

    public function deleteItem($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'DELETE 
            FROM App\Entity\Uploads e
            WHERE e.id = '.$id
        );
        return $query->getResult();
    }    
    // /**
    //  * @return Uploads[] Returns an array of Uploads objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Uploads
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
