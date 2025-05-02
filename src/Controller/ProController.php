<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


final class ProController extends AbstractController
{
    #[Route('/profil/pro', name: 'pro_profile')]
    public function index(AuthorizationCheckerInterface $authChecker): Response
    {
        // Vérifie si l'utilisateur a le rôle ROLE_PRO
        if (!$authChecker->isGranted('ROLE_PRO')) {
            // Si non, redirige vers la page d'accueil ou une autre page appropriée
            return $this->redirectToRoute('app_landing');
        }

        return $this->render('pro/profile.html.twig');
    }
}
