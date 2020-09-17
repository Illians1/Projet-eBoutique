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
        // gets an attribute by name

        if ($this->session->get('panier')) {
            $panier = $this->session->get('panier');
        } else {
            $panier = new Panier();
            $this->session->set('panier', $panier);
        }

        $panier->addArticle($id);
        $this->session->set('panier', $panier);
        // stores an attribute in the session for later reuse
        return $this->redirectToRoute('articles');
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
     * @Route("/removeAll", name="remove_all")
     */
    public function removeAll()
    {
        $this->session->remove('panier');
        $articles = array();
        return $this->render('articles/index.html.twig', [
            'controller_name' => 'ArticlesController', 'articles' => $articles,
        ]);
    }
}
