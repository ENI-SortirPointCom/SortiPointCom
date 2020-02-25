<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Entity\User;
use App\Form\SortieCreateType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    /**
     * @Route("/sortie/create", name="sortie_create")
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
}
