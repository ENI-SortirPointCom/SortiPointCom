<?php

namespace App\Controller;

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
        $sorties = $em->getRepository(Sortie::class)->findAll();
        $sites = $em->getRepository(Site::class)->findAll();
        $form = $this->createForm(SortieFilterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $site = $form->get('site')->getData();
            $isOrga = $form->get('organisateur')->getData();
            $em = $this->getDoctrine()->getManager();
            if ($isOrga){
                $sorties = $em->getRepository(Sortie::class)->findBy(array('organisateur'=>$this->getUser()));
            }


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
