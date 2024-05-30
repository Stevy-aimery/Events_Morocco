<?php

// src/Repository/EventRepository.php
namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function searchEvents($titre, $dateDebut, $lieu, $capacite)
    {
        $qb = $this->createQueryBuilder('e');

        if ($titre) {
            $qb->andWhere('e.titre LIKE :titre')
               ->setParameter('titre', '%' . $titre . '%');
        }

        if ($dateDebut) {
            $qb->andWhere('e.dateDebut >= :dateDebut')
               ->setParameter('dateDebut', $dateDebut);
        }
 
        if ($lieu) {
            $qb->andWhere('e.lieu LIKE :lieu')
               ->setParameter('lieu', '%' . $lieu . '%');
        }

        if ($capacite) {
            $qb->andWhere('e.capacite >= :capacite')
               ->setParameter('capacite', $capacite);
        }

        return $qb->getQuery()->getResult();
    }
     /**
     * @return Event[] Returns an array of Event objects
     */
    public function findByCategory(Category $category)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.category = :category')
            ->setParameter('category', $category)
            ->orderBy('e.date', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
