<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\NewPublicationFormType;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

        if ($form->isSubmitted() && $form->isValid()) {

            $newArticle
                ->setPublicationDate(new \DateTime())
                ->setAuthor($this->getUser());

            $em = $doctrine->getManager();
            $em->persist($newArticle);
            $em->flush();

            $this->addFlash('success', 'Article publié avec succès !');
            return $this->redirectToRoute('blog_publication_list', [
                'slug' => $newArticle->getSlug()

            ]);
        }


        return $this->render('blog/new_publication.html.twig', [
            'new_publication_form' => $form->createView()

        ]);
    }


    #[Route('/publications/liste/', name: 'publication_list')]
    public function publicationList(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator, $article): Response
    {
        $requestPage = $request->query->getInt('page', 1);
        if ($requestPage < 1) {
            throw new NotFoundHttpException();
        }
        $em = $doctrine->getManager();
        $query = $em->createQuery('SELECT a FROM App\Entity\Article a ORDER BY a.puclicationDate DESC');
        $articles = $paginator->paginate(
            $query,
            $requestPage,
            10
        );

        return $this->render('blog/publication_view.html.twig', [
            'article' => $article,


        ]);

    }

    #[Route('/publication/suppression/{id}/', name: 'publication_delete', priority: 10)]
    #[IsGranted('ROLE_ADMIN')]
    public function publicationDelete(Article $article, ManagerRegistry $doctrine, Request $request): Response
    {
        if (!$this->isCsrfTokenValid('blog_publication_delete_' . $article->getId(), $request->query->get('csrf_token'))) {
            $this->addFlash('error', 'Token sécurité invalide, veuillez réessayer');
        } else {
            $em = $doctrine->getManager();
            $em->remove($article);
            $em->flush();
            $this->addFlash('success', 'La publication a été publié avec succès');
        }
        return $this->redirectToRoute('blog_publication_list');

    }
}



















