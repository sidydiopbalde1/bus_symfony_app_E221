<?php

namespace App\Repository\Arret;

use App\Entity\Arret;
use App\Interfaces\Repositories\Arret\ArretRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ArretRepository extends ServiceEntityRepository implements ArretRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Arret::class);
    }

    public function add(Arret $arret): void
    {
        $this->getEntityManager()->persist($arret);
        $this->getEntityManager()->flush();
    }

    public function findByLigneId(int $ligneId): array
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.ligne', 'l')
            ->addSelect('l')
            ->where('l.id = :id')
            ->setParameter('id', $ligneId)
            ->getQuery()
            ->getResult();
    }
}
