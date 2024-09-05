<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/wish', name: 'wish_', methods: ['GET', 'POST'])]
class WishController extends AbstractController
{
    #[Route('', name: 'list')]
    public function list(): Response
    {
        //todo affichera la liste des choses à faire
        return $this->render('list.html.twig');
    }

    #[Route('/detail/{id}', name: 'detail', requirements: ['id' => '\d+'])]
    public function detail(int $id): Response
    {
        //todo affichera les détails d'une idée de la liste
        return $this->render('detail.html.twig');
    }
}
