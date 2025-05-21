<?php

namespace App\Controller;

use App\Enum\statusEnum;
use App\Entity\Office;
use App\Entity\TimeConfiguration;
use App\Form\OfficeForm;
use App\Form\TimeConfigurationForm;
use App\Repository\OfficeRepository;
use App\Repository\TimeConfigurationRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\OfficeClosure;
use App\Form\OfficeClosureFormType;
use App\Repository\OfficeClosureRepository;
use App\Entity\OfficeTypeOfService;
use App\Form\OfficeTypeOfServiceType;
use App\Entity\TypeOfService;
use App\Entity\Speciality;
use Symfony\Component\HttpFoundation\JsonResponse;

final class OfficeController extends AbstractController
{
    #[Route('/office/add', name: 'office_add')]
    public function new(Request $request, EntityManagerInterface $em): Response
{
    $office = new Office();
    $office->setUserId($this->getUser());
    $office->setStatus(statusEnum::Pending);

    $form = $this->createForm(OfficeForm::class, $office);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // ⬇️ Récupère les professions sélectionnées dans le formulaire
        $professions = $form->get('professions')->getData();

        // ⬇️ Les ajoute manuellement à l'entité Office
        foreach ($professions as $profession) {
            $office->addProfession($profession); // méthode de l'entité Office
        }

        $em->persist($office);
        
        $em->flush();
        
        $this->addFlash('success', 'Office enregistré avec succès.');
        return $this->redirectToRoute('office_show');
    }

    return $this->render('office/new.html.twig', [
        'form' => $form->createView(),
    ]);
}






    #[Route('/office', name: 'office_show')]
    public function showOffice(OfficeRepository $officeRepository): Response
    {
        $user = $this->getUser();
    
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour voir vos bureaux.');
        }
    
        // Récupère tous les bureaux liés à l'utilisateur connecté
        $offices = $officeRepository->findBy(['user' => $user]);
    
        return $this->render('office/show.html.twig', [
            'offices' => $offices,
        ]);
    }

    
    #[Route('/office/details/{id_off}', name: 'office_details')]
    public function detailsOffice(int $id_off, OfficeRepository $officeRepository, TimeConfigurationRepository $TimeConfigurationRepository ): Response
    {
        $user = $this->getUser();
    
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour voir vos bureaux.');
        }
        
      
        // Récupère le bureau par son id et vérifie s’il appartient à l’utilisateur
        $office = $officeRepository->findOneBy(['id' => $id_off, 'user' => $user]);
        $timeConf = $TimeConfigurationRepository->findBy(['office' => $office]);
        
        if (!$office) {
            throw $this->createNotFoundException('Bureau non trouvé ou non autorisé.');
        }
    
        return $this->render('office/detail.html.twig', [
            'office' => $office, 'timeConf' => $timeConf,
        ]);
    }


    #[Route('/office/{id_off}/timeAdd', name: 'time_add')]
    public function add(
        int $id_off,
        Request $request,
        EntityManagerInterface $entityManager,
        OfficeRepository $officeRepository
    ): Response {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté.');
        }

        $office = $officeRepository->findOneBy(['id' => $id_off, 'user' => $user]);

        if (!$office) {
            throw $this->createNotFoundException('Bureau non trouvé ou non autorisé.');
        }

        $timeConfiguration = new TimeConfiguration();
        $form = $this->createForm(TimeConfigurationForm::class, $timeConfiguration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère l'input brut du champ texte
            $rdvString = $form->get('rdvInterval')->getData();
            if ($rdvString) {
                try {
                    list($hours, $minutes, $seconds) = explode(':', $rdvString);
                    $intervalSpec = sprintf('PT%dH%dM%dS', $hours, $minutes, $seconds);
                    $interval = new \DateInterval($intervalSpec);
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Format de durée invalide. Utilisez HH:MM:SS');
                    return $this->redirectToRoute('time_add', ['id' => $id_off]);
                }
                if (!$interval) {
                    $this->addFlash('error', 'Format de durée invalide. Utilisez HH:MM:SS');
                    return $this->redirectToRoute('time_add', ['id' => $id_off]);
                }
                $timeConfiguration->setRdvInterval($interval);
            }

            $timeConfiguration->setOfficeId($office);

            $entityManager->persist($timeConfiguration);
            $entityManager->flush();

            $this->addFlash('success', 'Configuration horaire enregistrée.');

            return $this->redirectToRoute('schedules', ['id_off' => $id_off]);
        }

        return $this->render('office/timeConfForm.html.twig', [
            'form' => $form->createView(),
            'office' => $office,
        ]);
    }
    
    

     #[Route('/office/{id_off}/timeEdit/{id}', name: 'time_edit')]
    public function editTime(int $id_off, int $id,Request $request, OfficeRepository $officeRepository ,EntityManagerInterface $em): Response
    {
        
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté.');
        }

        $office = $officeRepository->findOneBy(['id' => $id_off, 'user' => $user]);

        if (!$office) {
            throw $this->createNotFoundException('Bureau non trouvé ou non autorisé.');
        }




        $timeConfiguration = $em->getRepository(TimeConfiguration::class)->find($id);
        if (!$timeConfiguration) {
                throw $this->createNotFoundException('Configuration horaire non trouvée.');
            }
         $form = $this->createForm(TimeConfigurationForm::class, $timeConfiguration);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Optionnel : gérer manuellement rdvInterval
            $rdvString = $form->get('rdvInterval')->getData();
            if ($rdvString) {
                try {
                    list($hours, $minutes, $seconds) = explode(':', $rdvString);
                    $intervalSpec = sprintf('PT%dH%dM%dS', $hours, $minutes, $seconds);
                    $interval = new \DateInterval($intervalSpec);
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Format de durée invalide. Utilisez HH:MM:SS');
                    return $this->redirectToRoute('time_add', ['id' => $id_off]);
                }
                if (!$interval) {
                    $this->addFlash('error', 'Format de durée invalide. Utilisez HH:MM:SS');
                    return $this->redirectToRoute('time_add', ['id' => $id_off]);
                }
                $timeConfiguration->setRdvInterval($interval);
            }
            $timeConfiguration->setOfficeId($office);
           

            $em->flush();

            $this->addFlash('success', 'Configuration horaire mise à jour.');

            return $this->redirectToRoute('office_details', ['id_off' => $id_off]);
        }

        return $this->render('office/timeConfEditForm.html.twig', [
            'form' => $form->createView(),'office' => $office,
        ]);
    }


    #[Route('/office/{id_off}/timeDelete/{id}', name: 'time_delete', methods: ['POST'])]
        public function deleteTime(
            int $id_off,
            int $id,
            Request $request,
            OfficeRepository $officeRepository,
            EntityManagerInterface $em
        ): Response {
            $user = $this->getUser();

            if (!$user) {
                throw $this->createAccessDeniedException('Vous devez être connecté.');
            }

            $office = $officeRepository->findOneBy(['id' => $id_off, 'user' => $user]);

            if (!$office) {
                throw $this->createNotFoundException('Bureau non trouvé ou non autorisé.');
            }

            $timeConfiguration = $em->getRepository(TimeConfiguration::class)->find($id);

            if (!$timeConfiguration) {
                throw $this->createNotFoundException('Configuration horaire non trouvée.');
            }

            // Vérifie qu'elle appartient bien au bureau
            if ($timeConfiguration->getOfficeId()->getId() !== $office->getId()) {
                throw $this->createAccessDeniedException('Vous ne pouvez pas supprimer cette configuration.');
            }

            if ($this->isCsrfTokenValid('delete_time_' . $id, $request->request->get('_token'))) {
                $em->remove($timeConfiguration);
                $em->flush();
                $this->addFlash('success', 'Configuration supprimée.');
            } else {
                $this->addFlash('error', 'Jeton CSRF invalide.');
            }

            return $this->redirectToRoute('schedules', ['id_off' => $id_off]);
        }

        /* TEST     TEST     TEST */
        
        /* #[Route('/offices', name: 'app_office_list')]
        public function list(OfficeRepository $officeRepository): Response
        {
            $offices = $officeRepository->findAll();

            return $this->render('test/list.html.twig', [
                'offices' => $offices,
            ]);
        } */

        #[Route('/office/{id}', name: 'app_office_show')]
public function show(Office $office, EntityManagerInterface $em): Response
{
    // Récupère toutes les liaisons OfficeTypeOfService
    $allServices = $em->getRepository(OfficeTypeOfService::class)->findAll();

    // Filtre les services associés à ce bureau
    $services = array_filter($allServices, function (OfficeTypeOfService $service) use ($office) {
        return $service->getOfficeId()->contains($office);
    });

    return $this->render('search/show.html.twig', [
        'office' => $office,
        'services' => $services,
    ]);
}


        /* TEST     TEST     TEST */


        #[Route('office/{id_off}/addClosure', name: 'add_closure')]
                public function officeClosure(int $id_off, Request $request, EntityManagerInterface $entityManager): Response
                {
                    $office = $entityManager->getRepository(Office::class)->find($id_off);

                    if (!$office) {
                        throw $this->createNotFoundException('Bureau non trouvé');
                    }

                    $officeClosure = new OfficeClosure();
                    $officeClosure->setOffice($office); 

                    $form = $this->createForm(OfficeClosureFormType::class, $officeClosure);
                    $form->handleRequest($request);

                    if ($form->isSubmitted() && $form->isValid()) {
                        $entityManager->persist($officeClosure);
                        $entityManager->flush();

                        $this->addFlash('success', 'Fermeture ajoutée avec succès.');
                        return $this->redirectToRoute('office_details', ['id_off' => $id_off]);
                    }

                    return $this->render('office/closureForm.html.twig', [
                        'form' => $form->createView(),
                        'office' => $office,
                    ]);
                }

            #[Route('/api/services/{specialityId}', name: 'api_get_services_by_speciality', methods: ['GET'])]
                public function getServicesBySpeciality(int $specialityId, EntityManagerInterface $em): JsonResponse
                {
                    $services = $em->getRepository(TypeOfService::class)->findBy([
                        'speciality' => $specialityId
                    ]);

                    $data = [];
                    foreach ($services as $service) {
                        $data[] = [
                            'id' => $service->getId(),
                            'name' => $service->getName()
                        ];
                    }

                    return new JsonResponse($data);
                }


        #[Route('/office/{id_off}/addService', name: 'service_add')]
public function addService(
    int $id_off,
    Request $request,
    EntityManagerInterface $em
): Response {
    $office = $em->getRepository(Office::class)->find($id_off);
    if (!$office) {
        throw $this->createNotFoundException('Bureau introuvable.');
    }

    $officeTypeOfService = new OfficeTypeOfService();
    $officeTypeOfService->addOfficeId($office);

    $form = $this->createForm(OfficeTypeOfServiceType::class, $officeTypeOfService, [
        'em' => $em
    ]);

    $form->handleRequest($request);

   if ($form->isSubmitted() && $form->isValid()) {
    // Récupérer la durée sous forme de string (ex: 00:30:00)
    $durationString = $form->get('duration')->getData();

    if ($durationString) {
        try {
            // Par exemple, si c'est un DateTimeInterface, on peut récupérer l'heure et les minutes
            if ($durationString instanceof \DateTimeInterface) {
                // Transforme en intervalle
                $interval = new \DateInterval(sprintf(
                    'PT%dH%dM%dS',
                    (int)$durationString->format('H'),
                    (int)$durationString->format('i'),
                    (int)$durationString->format('s')
                ));
            } elseif (is_string($durationString)) {
                // Si tu souhaites passer à du format texte (HH:MM:SS), tu peux l'exploser ici comme dans le contrôleur timeAdd
                $parts = explode(':', $durationString);
                if (count($parts) === 3) {
                    $interval = new \DateInterval(sprintf('PT%dH%dM%dS', $parts[0], $parts[1], $parts[2]));
                } else {
                    throw new \Exception('Format invalide');
                }
            } else {
                throw new \Exception('Format invalide');
            }
        } catch (\Exception $e) {
            $this->addFlash('error', 'Format de durée invalide.');
            return $this->redirectToRoute('service_add', ['id_off' => $id_off]);
        }

        // Exemple : tu stockes l'intervalle dans ton entité, méthode à adapter selon ton modèle
        $officeTypeOfService->setDuration($interval);
    }
    
    $em->persist($officeTypeOfService);
    $em->flush();

    $this->addFlash('success', 'Le service a été enregistré avec succès.');
    return $this->redirectToRoute('services',['id_off' => $id_off]);
    
}


    return $this->render('office/serviceAdd.html.twig', [
        'office' => $office,
        'form' => $form->createView()
    ]);
    
}

    #[Route('office/{id_off}/Closure', name: 'closure', methods: ['GET'])]
public function showClosure(int $id_off, EntityManagerInterface $em): Response
{
    $office = $em->getRepository(Office::class)->find($id_off);

    return $this->render('Office/closure.html.twig', [
        'office' => $office,
    ]);
}

    #[Route('office/{id_off}/Schedules', name: 'schedules', methods: ['GET'])]
public function showSchedules(int $id_off, EntityManagerInterface $em, TimeConfigurationRepository $TimeConfigurationRepository ): Response
{
    $office = $em->getRepository(Office::class)->find($id_off);
    $timeConf = $TimeConfigurationRepository->findBy(['office' => $office]);

    return $this->render('Office/schedules.html.twig', [
        'office' => $office,
        'timeConf' => $timeConf,
    ]);
}

    #[Route('office/{id_off}/Services', name: 'services', methods: ['GET'])]
public function showServices(int $id_off, EntityManagerInterface $em): Response
{
    $office = $em->getRepository(Office::class)->find($id_off);

    return $this->render('Office/services.html.twig', [
        'office' => $office,
    ]);
}

}