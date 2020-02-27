<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Form\VilleCreateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VilleController extends AbstractController
{
    /**
     * @Route("/ville/create", name="ville_create")
     */
    public function villeCreate(Request $request): Response
    {
        $ville = new Ville();

        $form = $this->createForm(VilleCreateType::class, $ville);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ville);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('ville/villeCreate.html.twig', [
            'controller_name' => 'Création d\'une ville',
            'villeCreateForm' => $form->createView(),

        ]);
    }
}
