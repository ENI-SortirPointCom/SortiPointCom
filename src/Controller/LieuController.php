<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\LieuCreateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LieuController extends AbstractController
{
    /**
     * @Route("/lieu/create", name="lieu_create")
     */
    public function LieuCreate(Request $request): Response
    {
        $lieu = new Lieu();

        $form = $this->createForm(LieuCreateType::class, $lieu);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lieu);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('lieu/lieuCreate.html.twig', [
            'controller_name' => 'Création d\'un lieu',
            'lieuCreateForm' => $form->createView(),

        ]);
    }
}
