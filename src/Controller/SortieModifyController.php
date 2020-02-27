<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieCancelType;
use App\Form\SortieModifyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SortieModifyController extends AbstractController
{
    /**
     * @Route("/sortie/modify/{id}", requirements={"id": "\d+"}, name="sortie_modify")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        /** @var Sortie $sortie */
        $sortie = $em->getRepository(Sortie::class)->find($request->get('id'));
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
}
