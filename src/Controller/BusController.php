<?php

namespace App\Controller;

use App\Entity\Bus;
use App\Entity\Conducteur;
use App\Enum\BusType;
use App\Repository\BusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class BusController extends AbstractController
{
    #[Route('/bus/list', name: 'app_bus_list')]
    public function index(BusRepository $busRepository): JsonResponse
    {
        $bus = $busRepository->findAll();
        $busArray = array_map(fn($bu) => $bu->toArray(), $bus);
        return $this->json([
            'message' => 'Liste des bus !',
            'bus' => $busArray,
        ]);
    }
    #[Route('/bus/create', name: 'bus_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        $bus = new Bus();
        $bus->setImmatriculation($data['immatriculation'])
            ->setType(BusType::from($data['type']))
            ->setKilometrage($data['kilometrage'])
            ->setNbrePlaces($data['nbrePlaces'])
            ->setEnCirculation($data['enCirculation']);
        
        if ($data['conducteur']) {
            $conducteur = $entityManager->getRepository(Conducteur::class)->find($data['conducteur']);
            $bus->setConducteur($conducteur);
        }
        
        $entityManager->persist($bus);
        $entityManager->flush();
        
        return $this->json(['message' => 'Bus créé avec succès', 'bus' => $bus]);
    }
    #[Route('/{immatriculation}', methods: ['DELETE'])]
    public function deleteBus(BusRepository $busRepository,EntityManagerInterface $entityManager,string $immatriculation): JsonResponse
    {
        $bus = $busRepository->findOneBy(['immatriculation' => $immatriculation]);

        if (!$bus) {
            return $this->json(['message' => 'Bus non trouvé'], 404);
        }

        $entityManager->remove($bus);
        $entityManager->flush();

        return $this->json(['message' => 'Bus supprimé avec succès']);
    }
}
