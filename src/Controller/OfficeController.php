<?php

namespace App\Controller;

use App\Enum\statusEnum;
use App\Entity\Office;
use App\Entity\TimeConfiguration;
use App\Form\OfficeForm;
use App\Form\TimeConfigurationForm;
use App\Repository\OfficeRepository;
use App\Repository\TimeConfigurationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

            return $this->redirectToRoute('office_details', ['id_off' => $id_off]);
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

            return $this->redirectToRoute('office_details', ['id_off' => $id_off]);
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

        #[Route('/office/{id}', name: 'app_office_show', methods: ['GET'])]
        public function show(Office $office): Response
        {
            return $this->render('test/show.html.twig', [
                'office' => $office,
            ]);
        }

        /* TEST     TEST     TEST */

}