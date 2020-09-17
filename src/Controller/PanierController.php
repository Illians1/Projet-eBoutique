<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Panier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        if ($this->session->get('panier')) {
            $panier = $this->session->get('panier');
        } else {
            $panier = new Panier();
            $this->session->set('panier', $panier);
        }
        $list = $panier->getListArticle();
        dump($list);

        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController', 'list' => $list,
        ]);
    }

    /**
     * @Route("/panier/{id}/{modif}", name="modif_panier", requirements={"id":"\d+"})
     */
    public function modifOne(Request $request, $id, $modif)
    {
        $article = $this->getDoctrine()->getRepository(Articles::class)->findOneBy(['idarticle' => $id]);
        {
            if ($this->session->get('panier')) {
                $panier = $this->session->get('panier');
            } else {
                $panier = new Panier();
                $this->session->set('panier', $panier);
            }

            $panier->modifArticle($modif, $article);
            $this->session->set('panier', $panier);
            // stores an attribute in the session for later reuse
            return $this->redirect($request->headers->get('referer'));
        }
    }
    /**
     * @Route("/panier/removeAll/{id}", name="panier_remove_all", requirements={"id":"\d+"})
     */
    public function removeAllArticle($id)
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
            }
        }
        $this->session->set('panier', $panier);
        return $this->redirectToRoute('panier');
    }
}
