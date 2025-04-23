<?php

namespace App\Controller;

use App\Entity\Station;
use App\Repository\StationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class StationController extends AbstractController
{
    #[Route('/stations/list', name: 'stations_list', methods: ['GET'])]
    public function index(StationRepository $stationRepository): JsonResponse
    {
        $stations = $stationRepository->findAll();
        $data = array_map(fn(Station $station) => $station->toArray(), $stations);

        return $this->json([
            'message' => 'Liste des stations',
            'station' => $data,
        ]);
    }

    #[Route('/station/create', name: 'station_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['numero'], $data['nom'], $data['adresse'])) {
            return $this->json(['message' => 'Champs requis manquants.'], 400);
        }

        $station = (new Station())
            ->setNumero($data['numero'])
            ->setNom($data['nom'])
            ->setAdresse($data['adresse']);

        $em->persist($station);
        $em->flush();

        return $this->json(['message' => 'Station créée', 'data' => $station->toArray()]);
    }

    //liste des stations par ligne
    #[Route('/station/ligne/{id}', name: 'station_by_ligne', methods: ['GET'])]
    public function getByLigne(int $id, StationRepository $stationRepository): JsonResponse
    {
        $stations = $stationRepository->findBy(['ligne' => $id]);

        if (!$stations) {
            return $this->json(['message' => 'Aucune station trouvée pour cette ligne'], 404);
        }

        $data = array_map(fn(Station $station) => $station->toArray(), $stations);

        return $this->json($data);
    }
}
