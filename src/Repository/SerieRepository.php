<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Serie>
 *
 * @method Serie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serie[]    findAll()
 * @method Serie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    public function findBestSeries()
    {
        //en DQL

        // $entityManager = $this->getEntityManager();
        // $dql = "    SELECT s
        //             FROM App\Entity\Serie s
        //             WHERE s.popularity > 100
        //             AND s.vote > 8
        //             ORDER BY s.popularity DESC
        // ";
        // $query = $entityManager->createQuery($dql);
        // $query->setMaxResults(50);
        // $results = $query->getResult();


        // dump($results); //check résultat et débug si besoin
        // return $results;

        //version QueryBuilder

        $queryBuilder = $this->createQueryBuilder('s');

        $queryBuilder->leftJoin('s.seasons', 'seas')->addSelect('seas');

        $queryBuilder->andWhere('s.popularity > 80');
        $queryBuilder->andWhere('s.vote > 7.5');
        $queryBuilder->addOrderBy('s.popularity','DESC');
        $query = $queryBuilder->getQuery();

        $query->setMaxResults(50);
        
        $paginator = new Paginator($query);

        return $paginator;
    }

}

    // public function add(Serie $entity, bool $flush = false): void
    // {
    //     $this->getEntityManager()->persist($entity);

    //     if ($flush) {
    //         $this->getEntityManager()->flush();
    //     }
    // }

    // public function remove(Serie $entity, bool $flush = false): void
    // {
    //     $this->getEntityManager()->remove($entity);

    //     if ($flush) {
    //         $this->getEntityManager()->flush();
    //     }
    // }
