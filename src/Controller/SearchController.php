<?php

// src/Controller/SearchController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_office_list')]
    public function search(Request $request, EntityManagerInterface $em): Response
    {
        $query = $request->query->get('q');
        $address = $request->query->get('address');


        $qb = $em->createQueryBuilder();
$qb->select('o')
   ->from('App\Entity\Office', 'o')
   ->leftJoin('o.professions', 'p'); // Jointure avec Profession

if ($query) {
    $qb->andWhere('o.businessName LIKE :keyword OR p.name LIKE :keyword')
       ->setParameter('keyword', '%' . $query . '%');
}



        /* $qb = $em->createQueryBuilder();
        $qb->select('o')
           ->from('App\Entity\Office', 'o');

        if ($query) {
            $qb->andWhere('o.businessName LIKE :keyword OR o.description LIKE :keyword')
               ->setParameter('keyword', '%' . $query . '%');
        } */

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
