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
        dump($panier);
        if ($panier != null) {
            $articles = $panier->getArticles();
        } else {
            $articles = array();
        }
        $newPanier = new Panier();
        foreach ($articles as $value) {
            if (array_key_exists($value->getIdarticle(), $arrayPanier)) {
                $i = $arrayPanier[$value->getIdarticle()];
                $i++;
                $arrayPanier[$value->getIdarticle()] = $i;
            } else {
                $arrayPanier[$value->getIdarticle()] = 1;
                $newPanier->addArticle($value);
            }
        }
        $newPanier->setNombreArticles($arrayPanier);
        dump($newPanier);

        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController', 'panier' => $newPanier, 'nombre' => $arrayPanier,
        ]);
    }
    /**
     * @Route("/panier/remove/{id}", name="panier_remove", requirements={"id":"\d+"})
     */
    public function removeArticle($id)
    {
        $panier = $this->session->get('panier');
        if ($panier != null) {
            $articles = $panier->getArticles();
        } else {
            $articles = array();
        }
        foreach ($articles as $value) {
            if ($value->getIdarticle() == $id) {
                $panier->removeArticle($value);
                $this->session->set('panier', $panier);
                return $this->redirectToRoute('panier');
            }
        }
    }
}