<?php

namespace App\Controller;

use App\Entity\Search;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\User;
use App\Form\ModalMotifFormType;
use App\Form\SortieCancelType;
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
            $sorties = $em->getRepository(Sortie::class)->findByLimitOneMonth();
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

//    /**
//     * @Route("/sortieCancel/{id}", requirements={"id": "\d+"}, name="accueil_cancel")
//     */
//    public function cancel(Request $request, EntityManagerInterface $em){
//
//        /** @var Sortie $sortie */
//        $sortie = $em->getRepository('App:Sortie')->find($request->get('id'));
//
//
//        $sortie->setInfosSortie('');
//
//        $form = $this->createForm(SortieCancelType::class,$sortie);
//
//        return $this->render('sortie/sortieCancel.html.twig', [
//            "sortie" => $sortie,
//            "controller_name" => 'Annuler la sortie',
//            'sortieCancel' => $form->createView(),
//            /**
//             * pour passer en parametre de l'extension twig pesonnalisée
//             */
//            'user' => $this->getUser()
//        ]);
//
//    }

    /**
     * @Route("/register/{id}", requirements={"id": "\d+"}, name="accueil_register")
     */
    public function register(Request $request, EntityManagerInterface $em)
    {
        /** @var User $user */
        $user = $this->getUser();

        /** @var Sortie $sortie */
        $sortie = $em->getRepository('App:Sortie')->find($request->get('id'));
        if ($user->getSorties()->contains($sortie)) {
            $user->removeSorty($sortie);
        } else {
            $user->addSorty($sortie);
        }

        $em->flush();

        return $this->redirectToRoute('accueil');
    }
}
