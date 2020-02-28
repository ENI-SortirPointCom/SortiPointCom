<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Entity\User;
use App\Form\SortieCancelType;
use App\Form\SortieCreateType;
use App\Form\SortieModifyType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    /**
     * @Route("/sortie/create", name="sortie_create")
     * @param Request $request
     * @return Response
     */
    public function sortieCreate(Request $request): Response
    {
        $sortie = new Sortie();

        $form = $this->createForm(SortieCreateType::class, $sortie);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $sortie->setOrganisateur($this->getUser());
            $sortie->setEtat($entityManager->getRepository('App:Etat')->find(2));
            $sortie->setSite($this->getUser()->getSite());
            $sortie->setEtat($entityManager->getRepository('App:Etat')->find(1));
            if ($form->get('participate')->getData()) {
                $this->getUser()->addSorty($sortie);
                $sortie->addParticipant($this->getUser());
            }
            $entityManager->persist($sortie);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('sortie/sortieCreate.html.twig', [
            'controller_name' => 'Création d\'une sortie',
            'sortieCreateForm' => $form->createView(),

        ]);
    }

    /**
     * @Route("/sortie/cancel/{id}", requirements={"id": "\d+"}, name="sortie_cancel")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        /** @var Sortie $sortie */
        $sortie = $em->getRepository(Sortie::class)->find($request->get('id'));

        $user = $this->getUser();
        $organiteur = $sortie->getOrganisateur();
        if ($user != $organiteur) {
            return $this->redirectToRoute('accueil');
        }

        $sortie->setInfosSortie('');
        $form = $this->createForm(SortieCancelType::class, $sortie);
        /**
         * si validé on affecte le motif et on set le status a ANNULE
         */
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $sortie->setEtat($em->getRepository('App:Etat')->find(5));
            $sortie->setInfosSortie($form->get('infosSortie')->getData());
            $em->persist($sortie);
            $em->flush();

            return $this->redirectToRoute('accueil');
        }
        return $this->render('sortie/sortieCancel.html.twig', [
            "sortie" => $sortie,
            "controller_name" => 'Annulation de la sortie ',
            'sortieCancel' => $form->createView()
        ]);
    }

    /**
     * @Route("/sortie/edit/{id}", requirements={"id": "\d+"}, name="sortie_edit")
     */
    public function update(Request $request, EntityManagerInterface $em)
    {


        /** @var Sortie $sortie */
        /** @var User $user */
        /** @var $organiteur */
        $sortie = $em->getRepository(Sortie::class)->find($request->get('id'));

        $user = $this->getUser();
        $organiteur = $sortie->getOrganisateur();
        if ($user != $organiteur) {
            return $this->redirectToRoute('accueil');
        }

        $sortie->setInfosSortie('');
        $form = $this->createForm(SortieModifyType::class, $sortie);
        $form->handleRequest($request);
        /**
         * a la subission du formulaire
         */
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($sortie);
            $em->flush();
            return $this->redirectToRoute('accueil');
        }
        return $this->render('sortie/sortieModify.html.twig', [
            'controller_name' => 'Modification de la sortie',
            'sortieModifyForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/sortie/show/{id}", requirements={"id": "\d+"}, name="sortie_show")
     */
    public function sortieShow(Request $request, EntityManagerInterface $em)
    {
        /** @var User $user */
        $user = $this->getUser();

        /** @var Sortie $sortie */

        $sortie = $em->getRepository('App:Sortie')->find($request->get('id'));
        return $this->render('sortie/sortieShow.html.twig', [
            'controller_name' => 'Sortie ',
            'sortie' => $sortie,
            'user' => $user
        ]);
    }

    /**
     * @Route("/sortie/register/{id}", requirements={"id": "\d+"}, name="sortie_register")
     */
    public function register(Request $request, EntityManagerInterface $em)
    {
        /** @var User $user */
        $user = $this->getUser();

        /** @var Sortie $sortie */
        $sortie = $em->getRepository('App:Sortie')->find($request->get('id'));
        if ($sortie->getEtat()->getLibelle() == 'ANNULE' || $sortie->getEtat()->getLibelle() == 'PASSE' || $sortie->getNbInscriptionMax() == $sortie->getParticipant()->count()) {
            return $this->redirectToRoute('accueil');
        }
        if ($user->getSorties()->contains($sortie)) {
            $user->removeSorty($sortie);
        } else {
            $user->addSorty($sortie);
        }
        $em->flush();

        return $this->redirectToRoute('sortie_show', ['id' => $sortie->getId()]);

    }
}
