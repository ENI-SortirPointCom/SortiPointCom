<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Entity\User;
use App\Form\SortieCancelType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SortieCancelController extends AbstractController
{
    /**
     * @Route("/sortie/cancel/{id}", requirements={"id": "\d+"}, name="sortie_cancel")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        /** @var Sortie $sortie */
        $sortie = $em->getRepository(Sortie::class)->find($request->get('id'));
        $sortie->setInfosSortie('');
        $form = $this->createForm(SortieCancelType::class, $sortie);

        /**
         * si validé on affecte le motif et on set le status a ANNULE
         */
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!is_null($sortie->setInfosSortie($form->get('infosSortie')->getData()))) {
                $sortie->setEtat($em->getRepository('App:Etat')->find(5));
                $sortie->setInfosSortie($form->get('infosSortie')->getData());
            }
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
}
