<?php

namespace App\Controller;

use App\Entity\Rdv;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use App\Entity\Office;
use App\Repository\OfficeRepository;



//for the api route
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\RdvRepository;


final class ProController extends AbstractController
{
    #[Route('/pro/home', name: 'pro_home')]
    public function index(AuthorizationCheckerInterface $authChecker): Response
    {
        // Vérifie si l'utilisateur a le rôle ROLE_PRO
        if (!$authChecker->isGranted('ROLE_PRO')) {
            // Si non, redirige vers la page d'accueil ou une autre page appropriée
            return $this->redirectToRoute('app_landing');
        }

        return $this->render('pro/home.html.twig');
    }

     #[Route('/booking/{id}', name: 'app_bookink')]
public function booking(int $id, RdvRepository $rdvRepository,AuthorizationCheckerInterface $authChecker): Response {
    if (!$authChecker->isGranted('ROLE_PRO')) {
        return $this->redirectToRoute('app_landing');
    }

    $rdv = $rdvRepository->find($id);

    if (!$rdv) {
        throw $this->createNotFoundException('Rendez-vous non trouvé.');
    }

    return $this->render('pro/booking.html.twig', [
        'rdv' => $rdv
    ]);
}

    #[Route('/pro/appointments', name: 'pro_appoint')]
    public function appointments(AuthorizationCheckerInterface $authChecker): Response 
    {
        // Vérifie si l'utilisateur a le rôle pro
        if (!$authChecker->isGranted('ROLE_PRO')) {
            return $this->redirectToRoute('app_landing');
        }
        
        return $this->render('appointment/index.html.twig');
    }

    //DB Call test :

    #[Route('/api/appointments', name: 'api_appoint')]
    public function apiAppoint(
        RdvRepository $rdvRepository,
        AuthorizationCheckerInterface $authChecker
    ): Response {
        $user = $this->getUser();
    
        if (!$authChecker->isGranted('ROLE_PRO')) {
            return $this->redirectToRoute('app_landing');
        }
    
        $rdvs = $rdvRepository->findForPro($user);
    
        // transform as needed for the calendar
        $events = array_map(function ($rdv) {
            $office = $rdv->getOfficeId();
            $pro = $office->getUserId();
            $service = $rdv->getOfficeTypeOfServiceId();
            $customer = $rdv->getUserId();
        
            // Collect type of service names
            $typeNames = [];
            if ($service) {
                foreach ($service->getTypeOfServiceId() as $typeOfService) {
                    $typeNames[] = $typeOfService->getName();
                }
            }
        
            return [
                'id' => $rdv->getId(),
                'price' => $service?->getPrice(),
                'duration' => $service?->getDuration()?->format('%H:%I:%S'),
                //'service_name' => $service?->getName(), // Optional, if you add a getName() method to OfficeTypeOfService
                'type_names' => $typeNames, // ✅ This is your array of related TypeOfService names
        
                'pro_name' => $pro?->getFirstname() . ' ' . $pro?->getLastname(),
                'pro_email' => $pro?->getEmail(),
                
                'office_name' => $office?->getBusinessName(),
                'office_address' => $office?->getOfficeAddress(),
                'office_city' => $office?->getOfficeCity(),

                'customer_lastname' => $customer?->getLastname(),
                'customer_name' => $customer?->getFirstname(),
                'customer_email' => $customer?->getEmail(),
                'customer_address' => $customer?->getAddress(),
                'customer_phone' => $customer?->getPhoneNumber(),
        
                'start' => $rdv->getDate()->format('Y-m-d') . 'T' . $rdv->getHourOfRdv()->format('H:i:s'),
                'end'   => $rdv->getDate()->format('Y-m-d') . 'T' . $rdv->getEndOfRdv()->format('H:i:s'),
            ];
        }, $rdvs);
    
        return new JsonResponse($events);
    }

   


    
}