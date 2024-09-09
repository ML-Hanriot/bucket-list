<?php

namespace App\Controller;
use App\Entity\Wish;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/wish', name: 'wish_')]
class WishController extends AbstractController
{

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->findBy(
            ['isPublished' => 1],    // Filtre : uniquement les éléments publiés (isPublished = 1)
            ['dateCreated' => 'DESC'] // Tri : du plus récent au plus ancien
        );
        return $this->render('list.html.twig', ['wish' => $wish]);

    }

    #[Route('/detail/{id}', name: 'detail', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function detail(Wish $wish): Response
    {
        //todo affichera les détails d'une idée de la liste
        return $this->render('detail.html.twig', ['wish' => $wish]);
    }
}
