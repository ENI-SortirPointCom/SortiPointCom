<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Entity\User;
use App\Form\SortieCreateType;
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
        if ($user->getSorties()->contains($sortie)) {
            $user->removeSorty($sortie);
        } else {
            $user->addSorty($sortie);
        }
        $em->flush();

        return $this->redirectToRoute('sortie_show', ['id' => $sortie->getId()]);
    }
}
