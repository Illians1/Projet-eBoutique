<?php

namespace App\Controller;

use App\Entity\Panier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Articles;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function showpanier()
    {
        $repository = $this->getDoctrine()->getRepository(Articles::class);
        $articles = $repository->findAll();
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController', 'articles' => $articles,
        ]);
    }
}