<?php

namespace App\Controller;

use App\Entity\Search;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Form\SortieFilterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        $sites = $em->getRepository(Site::class)->findAll();
        $search = new Search();
        $form = $this->createForm(SortieFilterType::class, $search);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $sorties = $em->getRepository(Sortie::class)->findBySearch($this->getUser(), $search);
        } else {
            $sorties = $em->getRepository(Sortie::class)->findAll();
        }


        return $this->render('accueil/index.html.twig', [
            "sorties" => $sorties,
            "sites" => $sites,
            "controller_name" => 'Accueil',
            'sortieFilterForm' => $form->createView(),
            /**
             * pour passer en parametre de l'extension twig pesonnalisée
             */
            'user' => $this->getUser()
        ]);
    }


//public function formSearchSortie(Request $request)
//{
//    $form = $this->createForm(SortieFilterType::class);
//    $form->handleRequest($request);
//
//    return $this->render('accueil/sortieFilter.html.twig', [
//        'sortieFilterForm' => $form->createView()
//    ]);
//
//
//}


}
