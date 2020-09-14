<?php

namespace App\Controller;

use App\Entity\Articles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
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
        dump($articles);

        // in the template, print things with {{ product.name }}
        return $this->render('articles/index.html.twig', ['articles' => $articles]);
    }
}