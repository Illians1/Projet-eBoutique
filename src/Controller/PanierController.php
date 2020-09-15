<?php

namespace App\Controller;

use App\Entity\Panier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
    /**
     * @Route("/panier", name="panier")
     */
    public function showpanier()
    {
        $panier = $this->session->get('panier');
        $articlesPanier = array();
        dump($panier);
        if ($panier != null) {
            $articles = $panier->getArticles();
        } else {
            $articles = array();
        }
        foreach ($articles as $valueArticle) {
            foreach ($articlesPanier as $valuePanier) {
                if ($valuePanier == $valueArticle) {

                }
            }
        }
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController', 'articles' => $articles,
        ]);
    }
}