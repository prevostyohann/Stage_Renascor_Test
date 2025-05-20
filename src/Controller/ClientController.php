<?php

namespace App\Controller;

use App\Repository\RdvRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


final class ClientController extends AbstractController
{
    #[Route('/client/home', name: 'client_home')]
    public function index(AuthorizationCheckerInterface $authChecker): Response
    {
        // Vérifie si l'utilisateur a le rôle ROLE_CLIENT
        if (!$authChecker->isGranted('ROLE_CLIENT')) {
            // Si non, redirige vers la page d'accueil ou une autre page appropriée
            return $this->redirectToRoute('app_landing');
        }

        return $this->render('client/home.html.twig');
    }

    #[Route('/client/appointments', name: 'client_appointments')]
public function clientAppointments(RdvRepository $rdvRepository): Response
{
    $user = $this->getUser();

    if (!$user) {
        throw $this->createAccessDeniedException('Vous devez être connecté.');
    }

    // On récupère tous les RDVs pour ce client
    $rdvs = $rdvRepository->findBy(['user' => $user]);


    return $this->render('client/appointments.html.twig', [
        'rdvs' => $rdvs,
    ]);
}

    
}
