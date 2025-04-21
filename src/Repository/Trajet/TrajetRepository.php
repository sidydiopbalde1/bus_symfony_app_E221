<?php

namespace App\Repository\Trajet;

use App\Entity\Trajet;
use App\Interfaces\Repositories\Trajet\TrajetRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TrajetRepository extends ServiceEntityRepository implements TrajetRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trajet::class);
    }

  
        public function save(Trajet $trajet): void
{
    $em = $this->getEntityManager(); // ✅ sécurité et clarté
    $em->persist($trajet);
    $em->flush();
}

    

    public function findAll(): array
    {
        return parent::findAll();
    }

    public function hasTrajetForBusAtDate(int $busId, \DateTimeInterface $date): bool
    {
        $start = (clone $date instanceof \DateTime ? $date : new \DateTime($date->format('Y-m-d H:i:s')))->setTime(0, 0, 0);
        $end = (clone $date instanceof \DateTime ? $date : new \DateTime($date->format('Y-m-d H:i:s')))->setTime(23, 59, 59);
    
        $qb = $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->where('t.bus = :busId')
            ->andWhere('t.datePlanification BETWEEN :start AND :end')
            ->setParameter('busId', $busId)
            ->setParameter('start', $start)
            ->setParameter('end', $end);
    
        return $qb->getQuery()->getSingleScalarResult() > 0;
    }
    
}
