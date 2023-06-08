<?php

namespace App\Controller;

use App\Form\NewPublicationFormType;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Préfixe de la route et du nom de toutes les pages de la partie blog du site
 */


#[Route('/blog', name: 'blog_')]

class BlogController extends AbstractController
{
    #[Route('/nouvelle-publication/', name: 'new_publication')]
    #[IsGranted('ROLE_ADMIN')]
    public function newPublication(Request $request, ManagerRegistry $doctrine): Response
    {
        $newArticle = new Article();

        $form = $this->createForm(NewPublicationFormType::class, $newArticle);

        $form->handleRequest($request);

        if ($form->isSubmitted() &&  $form->isValid()){

            $newArticle
                ->setPublicationDate(new \DateTime())
                ->setAuthor( $this->getUser() )
                ;

    $em = $doctrine->getManager();
    $em->persist($newArticle);
    $em->flush();

    $this->addFlash('success', 'Article publié avec succès !');
    return $this->redirectToRoute('main_home');
        }


        return $this->render('blog/new_publication.html.twig', [
            'new_publication_form' => $form->createView()

        ]);
    }
}
