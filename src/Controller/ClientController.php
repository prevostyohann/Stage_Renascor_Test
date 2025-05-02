<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class ClientController extends AbstractController
{
    #[Route('/profil/client', name: 'client_profile')]
    public function index(AuthorizationCheckerInterface $authChecker): Response
    {
        // Vérifie si l'utilisateur a le rôle ROLE_CLIENT
        if (!$authChecker->isGranted('ROLE_CLIENT')) {
            // Si non, redirige vers la page d'accueil ou une autre page appropriée
            return $this->redirectToRoute('app_landing');
        }

        return $this->render('client/profile.html.twig');
    }
}
