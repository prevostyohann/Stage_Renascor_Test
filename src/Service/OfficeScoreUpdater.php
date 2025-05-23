<?php

namespace App\Service;

use App\Entity\Office;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;

class OfficeScoreUpdater
{
    public function __construct(
        private ReviewRepository $reviewRepository,
        private EntityManagerInterface $em
    ) {}

    public function updateOfficeScore(Office $office): void
    {
        $reviews = $this->reviewRepository->findBy(['office' => $office]);
        if (count($reviews) === 0) {
            $office->setScore(null); // ou 0 si tu veux forcer une valeur
        } else {
            $average = array_sum(array_map(
                fn($review) => $review->getNote()->value,
                $reviews
            )) / count($reviews);
            $office->setScore(round($average));
        }

        $this->em->persist($office);
        $this->em->flush();
    }
}