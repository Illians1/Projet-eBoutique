<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Panier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/", name="articles")
     */
    public function showAll()
    {
        $repository = $this->getDoctrine()->getRepository(Articles::class);
        $articles = $repository->findAll();
        return $this->render('articles/index.html.twig', [
            'controller_name' => 'ArticlesController', 'articles' => $articles,
        ]);
    }

    /**
     * @Route("/articles/{id}", name="articles_add", requirements={"id":"\d+"})
     */
    public function addId($id)
    {
        $repository = $this->getDoctrine()->getRepository(Articles::class);
        $articles = $repository->findAll();
        dump($articles);

        // gets an attribute by name
        $panier = $this->session->get('panier');
        if ($panier->getArticles() != null) {
            $articlesPanier = $panier->getArticles();
        } else {
            $articlesPanier = array();
        }
        foreach ($articles as $value) {
            if ($value->getIdarticle() == $id) {
                dump($value);
                $ajout = new Panier();
                $ajout->addArticle($value);
                dump($ajout);
            }
        }

        // stores an attribute in the session for later reuse
        $this->session->set('panier', $ajout);

        $panier = $this->session->get('panier');
        dump($panier);
        return $this->render('articles/index.html.twig', ['articles' => $articles]);
    }

    /**
     * @Route("/articles/{categorie}", name="articles_categorie")
     */
    public function showCategorie($categorie)
    {
        $articles = $this->getDoctrine()->getManager()->getRepository(Articles::class)->findByCategorie($categorie);
        if (!$articles) {
            throw $this->createNotFoundException(
                'No product found for category ' . $categorie
            );
        }

        // in the template, print things with {{ article.name }}
        return $this->render('articles/index.html.twig', ['articles' => $articles]);
    }

    /**
     * @Route("/count", name="articles")
     */
    public function count()
    {
        $count = Panier::countArticles();
        dump($count);

        return $this->render('articles/index.html.twig');
    }
}