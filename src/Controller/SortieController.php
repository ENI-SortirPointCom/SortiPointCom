<?php

namespace App\Controller;

use App\Form\SortieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    /**
     * @Route("/sortie/create", name="sortieCreate")
     */
    public function sortieCreate(Request $request): Response
    {
        $form = $this->createForm(SortieType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist();
            $entityManager->flush();
        }
        return $this->render('sortie/sortieCreate.html.twig', [
            'controller_name' => 'Création d\'une sortie',
            'sortieCreateForm' => $form->createView(),
        ]);
    }
}
