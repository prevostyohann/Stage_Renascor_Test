<?php

namespace App\Controller;

use App\Enum\statusEnum;
use App\Entity\Office;
use App\Form\OfficeForm;
use App\Repository\OfficeRepository;
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
        $office->setUserId($this->getUser()); // Associe l'utilisateur connecté
        $office->setStatus(statusEnum::Pending);

        $form = $this->createForm(OfficeForm::class, $office);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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





}
