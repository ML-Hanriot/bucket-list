<?php

namespace App\Controller;
use App\Entity\Wish;
use App\Form\CreateBucketType;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        //crée une entité vide
        $wish = new Wish();
        //associe le formulaire à l'entité vide
        $wishForm = $this->createForm(WishType::class, $wish);
        //traitement du formulaire
        $wishForm->handleRequest($request);
        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            //car retourne une erreur sql vu que la valeur de datecreated n'est pas hydratée
            $wish->setPublished(true);
            $wish->setDateCreated(new \DateTime()); //fin
            //sauvegarde en BDD
            $entityManager->persist($wish);
            $entityManager->flush();
            //message flash
            $this->addFlash('success', 'Idea successfully added!');
            //redirection
            return $this->redirectToRoute('wish_detail', ['id' => $wish->getId()]);
        }
        //affiche le formulaire
        return $this->render('create.html.twig', ['wishForm' => $wishForm->createView()]);
    }
}
