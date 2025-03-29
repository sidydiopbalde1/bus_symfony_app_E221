<?php

namespace App\Controller;

use App\Entity\Conducteur;
use App\Enum\PermisType;
use App\Repository\ConducteursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


final class ConducteursController extends AbstractController
{
    #[Route('/conducteurs/list', name: 'app_conducteurs', methods: ['GET'])]
    public function index(ConducteursRepository $conducteursRepository): JsonResponse
    {
        $conducteurs = $conducteursRepository->findAll();
    
        // Convertir les objets Conducteur en tableau
        $conducteursArray = array_map(fn($conducteur) => $conducteur->toArray(), $conducteurs);
    
        return $this->json([
            'message' => 'Liste des conducteurs !',
            'conducteurs' => $conducteursArray,
        ]);
    }

    #[Route('/conducteurs/create', name: 'conducteur_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        // if (!isset($data['nom'], $data['prenom'], $data['telephone'], $data['typePermis'], $data['enCirculation'])) {
        //     return $this->json(['message' => 'Des données requises sont manquantes.'], 400);
        // }
    
        $conducteur = new Conducteur();
        $conducteur->setNom($data['nom'])
            ->setPrenom($data['prenom'])
            ->setTypePermis($data['typePermis'])
            ->setMatricule($data['matricule'])
            ->setTelephone($data['telephone']);
    
     
    
        $entityManager->persist($conducteur);
        $entityManager->flush();
    
        return $this->json(['message' => 'conducteur créé avec succès', 'conducteur' => $conducteur]);
    }
    
       
}

