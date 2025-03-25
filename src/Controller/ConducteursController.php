<?php

namespace App\Controller;

use App\Repository\ConducteursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

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
    
       
}

