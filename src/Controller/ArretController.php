<?php

namespace App\Controller;

use App\Entity\Arret;
use App\Repository\ArretRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ArretController extends AbstractController
{
    #[Route('/arrets/list', name: 'arrets_list', methods: ['GET'])]
    public function index(ArretRepository $repo): JsonResponse
    {
        $arrets = $repo->findAll();
        $data = array_map(fn(Arret $arret) => $arret->toArray(), $arrets);

        return $this->json(['message' => 'Liste des arrêts', 'data' => $data]);
    }

    #[Route('/arret/create', name: 'arret_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['nom'])) {
            return $this->json(['message' => 'Nom requis'], 400);
        }

        $arret = (new Arret())->setNom($data['nom'])
            ->setNumero($data['numero'] ?? null); 

        $em->persist($arret);
        $em->flush();

        return $this->json(['message' => 'Arrêt créé', 'data' => $arret->toArray()]);
    }
}
