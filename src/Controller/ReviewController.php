<?php

namespace App\Controller;

use App\Entity\Office;
use App\Entity\Review;
use App\Form\ReviewTypeForm;
use App\Repository\OfficeRepository;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;




final class ReviewController extends AbstractController
{
    #[Route('/office/{id}/review', name: 'app_review_new')]
public function new(
    Request $request,
    Office $office,
    EntityManagerInterface $em,
    Security $security
): Response {
    $user = $security->getUser();

    $review = new Review();
    $review->setUserId($user);
    $review->setOfficeId($office);

    $form = $this->createForm(ReviewTypeForm::class, $review);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($review);
        $em->flush();

        $this->addFlash('success', 'Avis enregistré avec succès !');
        return $this->redirectToRoute('app_office_show', ['id' => $office->getId()]);
    }

    return $this->render('test/new.html.twig', [
        'form' => $form->createView(),
        'office' => $office,
    ]);
}

        #[Route('/pro/reviews', name: 'pro_reviews')]
        public function showMyReviews(Security $security, OfficeRepository $officeRepo): Response
        {
            $user = $security->getUser();

            if (!$user) {
                throw $this->createAccessDeniedException('Non autorisé');
            }

            // On récupère tous les bureaux du professionnel connecté
            $offices = $officeRepo->findBy(['user' => $user]);

            return $this->render('review/pro.html.twig', [
                'offices' => $offices,
            ]);
        }


        #[Route('/client/reviews', name: 'client_reviews')]
        public function clientReviews(Security $security, ReviewRepository $reviewRepo): Response
        {
            $user = $security->getUser();

            if (!$user) {
                throw $this->createAccessDeniedException('Non autorisé');
            }

            $reviews = $reviewRepo->findBy(['user' => $user]);

            return $this->render('review/client.html.twig', [
                'reviews' => $reviews,
            ]);
        }


}
