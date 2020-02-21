<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        if ($this->getUser()) {
            return $this->render('default/index.html.twig', [
                'controller_name' => 'DefaultController',
            ]);
        }
        else{
            return $this->redirectToRoute('app_login');
        }

    }
}
