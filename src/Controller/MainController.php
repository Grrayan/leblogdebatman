<?php

namespace App\Controller;

use         Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class MainController extends AbstractController
{

/**
* Contrôleur de la page d'accueil
*/
#[Route('/', name: 'main_home')]
public function home(): Response
{
return $this->render('main/home.html.twig');
}

/**
* Contrôleur de la page de profil
*
* Accès réservé aux personnes connectées (ROLE_USER)
*/

#[Route('/mon-profil/', name: 'main_profil')]
#[IsGranted('ROLE_USER')]
public function profil(): Response
{
return $this->render('main/profil.html.twig');


}

}