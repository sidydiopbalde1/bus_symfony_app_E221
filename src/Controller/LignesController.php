<?php

namespace App\Controller;

use App\Entity\Ligne;
use App\Repository\LigneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class LignesController extends AbstractController
{
    #[Route('/lignes/list', name: 'lignes_list', methods: ['GET'])]
    public function index(LigneRepository $ligneRepository): JsonResponse
    {
        $lignes = $ligneRepository->findAll();
        $data = array_map(fn(Ligne $ligne) => $ligne->toArray(), $lignes);

        return $this->json([
            'message' => 'Liste des lignes',
            'lignes' => $data,
        ]);
    }

    #[Route('/ligne/create', name: 'ligne_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['nbrKilometre'], $data['tarif'], $data['etat'])) {
            return $this->json(['message' => 'Champs requis manquants.'], 400);
        }

        $ligne = (new Ligne())
            ->setNbrKilometre($data['nbrKilometre'])
            ->setTarif($data['tarif'])
            ->setEtat($data['etat'])
            ->setDateCreation((new \DateTime())->setTime(0, 0));

        $em->persist($ligne);
        $em->flush();

        return $this->json(['message' => 'Ligne créée', 'data' => $ligne->toArray()]);
    }

    #[Route('/ligne/delete/{id}', name: 'ligne_delete', methods: ['DELETE'])]
    public function delete(int $id, LigneRepository $repo, EntityManagerInterface $em): JsonResponse
    {
        $ligne = $repo->find($id);

        if (!$ligne) {
            return $this->json(['message' => 'Ligne non trouvée'], 404);
        }

        $em->remove($ligne);
        $em->flush();

        return $this->json(['message' => 'Ligne supprimée']);
    }

    #[Route('/ligne/update/{id}', name: 'ligne_update', methods: ['PUT'])]
    public function update(int $id, Request $request, LigneRepository $repo, EntityManagerInterface $em): JsonResponse
    {
        $ligne = $repo->find($id);

        if (!$ligne) {
            return $this->json(['message' => 'Ligne non trouvée'], 404);
        }

        $data = json_decode($request->getContent(), true);

        $ligne->setNbrKilometre($data['nbrKilometre'] ?? $ligne->getNbrKilometre())
              ->setTarif($data['tarif'] ?? $ligne->getTarif())
              ->setEtat($data['etat'] ?? $ligne->getEtat());

        $em->flush();

        return $this->json(['message' => 'Ligne mise à jour', 'data' => $ligne->toArray()]);
    }
}
