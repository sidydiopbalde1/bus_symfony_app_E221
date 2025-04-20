<?php

namespace App\Repository\Ligne;

use App\Entity\Ligne;
use App\Interfaces\Repositories\Ligne\LigneRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LigneRepository extends ServiceEntityRepository implements LigneRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ligne::class);
    }

    public function findAllWithArretCount(): array
    {
        return $this->createQueryBuilder('l')
            ->leftJoin('l.arrets', 'a')
            ->addSelect('COUNT(a.id) AS arretCount')
            ->groupBy('l.id')
            ->getQuery()
            ->getResult();
    }
    public function findLigneById(int $id): ?Ligne
    {
        return $this->createQueryBuilder('l')
            ->where('l.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByIdWithArretCount(int $id): ?array
    {
        return $this->createQueryBuilder('l')
            ->leftJoin('l.arrets', 'a')
            ->addSelect('COUNT(a.id) AS arretCount')
            ->where('l.id = :id')
            ->setParameter('id', $id)
            ->groupBy('l.id')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByIdWithArrets(int $id): ?Ligne
    {
        return $this->createQueryBuilder('l')
            ->leftJoin('l.arrets', 'a')
            ->addSelect('a')
            ->where('l.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function addLigne(Ligne $ligne): void
    {
        $this->getEntityManager()->persist($ligne);
        $this->getEntityManager()->flush();
    }

    public function removeLigne(Ligne $ligne): void
    {
        $this->getEntityManager()->remove($ligne);
        $this->getEntityManager()->flush();
    }

    public function updateLigne(): void
    {
        $this->getEntityManager()->flush();
    }
}
