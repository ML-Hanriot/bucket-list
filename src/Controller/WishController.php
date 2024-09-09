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
        $wishes = $wishRepository->findBy(
            ['isPublished' => 1],    // Filtre : uniquement les éléments publiés (isPublished = 1)
            ['dateCreated' => 'DESC'] // Tri : du plus récent au plus ancien
        );
        return $this->render('list.html.twig', ['wishes' => $wishes]);

    }

    #[Route('/detail/{id}', name: 'detail', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function detail(int $id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);
        // s'il n'existe pas en bdd, on déclenche une erreur 404
         if (!$wish){
            throw $this->createNotFoundException('This wish do not exists! Sorry!');
         }
        return $this->render('detail.html.twig', ['wish' => $wish]);
    }
}
