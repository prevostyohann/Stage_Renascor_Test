<?php

// src/Controller/SearchController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Enum\statusEnum;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_office_list')]
public function search(Request $request, EntityManagerInterface $em): Response
{
    $query = $request->query->get('q');
    $address = $request->query->get('address');

    $qb = $em->createQueryBuilder();
    $qb->select('o')
       ->addSelect('COALESCE(o.score, 0) AS HIDDEN score_order') // pour trier même si score est NULL
       ->from('App\Entity\Office', 'o')
       ->leftJoin('o.professions', 'p')
       ->andWhere('o.status = :activeStatus')
       ->setParameter('activeStatus', statusEnum::Active)
       ->orderBy('score_order', 'DESC'); // tri par score (NULL -> 0)

    if ($query) {
        $qb->andWhere('o.businessName LIKE :keyword OR p.name LIKE :keyword')
           ->setParameter('keyword', '%' . $query . '%');
    }

    if ($address) {
        $qb->andWhere('o.officeAddress LIKE :address')
           ->setParameter('address', '%' . $address . '%');
    }

    $offices = $qb->getQuery()->getResult();

    return $this->render('search/results.html.twig', [
        'offices' => $offices,
        'q' => $query,
        'address' => $address,
    ]);
}
}
