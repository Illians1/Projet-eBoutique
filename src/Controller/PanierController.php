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
        $arrayPanier = array();
        $doublons = array();
        dump($panier);
        if ($panier != null) {
            $articles = $panier->getArticles();
        } else {
            $articles = array();
        }
        foreach ($articles as $value) {
            if (!in_array($value->getIdarticle(), $arrayPanier)) {
                $arrayPanier[] = $value->getIdarticle();
                $articlesPanier[]= $value;
            } else {
                $doublons[] = $value;
            }
        }
        dump($articlesPanier);
        foreach ($doublons as $value) {
            foreach ($articlesPanier as $value2) {
                if ($value->getIdarticle()==$value2->getIdarticle()) {
                    $i = $value2->getNombre();
                    $i++;
                    $value2->setNombre($i);
                }
            }
        }
        dump($articlesPanier);
        dump($doublons);
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController', 'articles' => $articlesPanier,
        ]);
    }
}
