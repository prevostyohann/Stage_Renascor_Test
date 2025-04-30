<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\UserRegistrationFormType;
use App\Entity\User;

class UserRegistrationController extends AbstractController
{
    #[Route('/register/{type}', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        string $type = 'client'
    ) {
        $user = new User();

        $form = $this->createForm(UserRegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération et hashage du mot de passe
            $plainPassword = $form->get('plainPassword')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            // Attribution du rôle en fonction du type
            if ($type === 'pro') {
                $user->setRoles(['ROLE_PRO']);
            } else {
                $user->setRoles(['ROLE_CLIENT']);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Inscription réussie !');

            return $this->redirectToRoute('app_landing');
        }

        return $this->render('user_registration/index.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
