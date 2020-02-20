<?php

namespace App\Controller;

use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(EntityManagerInterface $em)
    {
        $sorties = $em->getRepository(Sortie::class)->findAll();




        return $this->render('accueil/index.html.twig', [
            "sorties" => $sorties,
            /**
             * pour passer en parametre de l'extension twig pesonnalisée
             */
            'user' => $this->getUser()
        ]);
    }

}
