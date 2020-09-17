<?php

namespace App\Entity;

use App\Entity\Articles;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Panier
{

    private $articles;

    private $nombreArticles = [];

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function modifArticle($modif, $article)
    {
        if ($modif == "ajout") {
            $this->articles[] = $article;
            return $this;
        } elseif ($modif == "delete") {
            foreach ($this->articles as $value) {
                if ($value->getIdarticle() == $article->getIdarticle()) {
                    unset($value);
                    return $this;
                }
            }
        }
    }

    public function getListArticle()
    {
        $listArticles = array();
        $listId = array();
        foreach ($this->articles as $article) {
            if (!in_array($article->getIdarticle(), $listId)) {
                $listArticle[] = $article;
                $listId[] = $article->getIdarticle();
            }
        }

        return $listArticle;
    }

    public function getTotal()
    {
        $sum = 0;
        foreach ($this->articles as $value) {
            $sum = $sum + $value->getPrixarticle();
        }
        return $sum;
    }

    public function getNombreArticles($id): ?int
    {
        $n = 0;
        foreach ($this->articles as $value) {
            if ($value->getIdarticle() == $id) {
                $n++;
            }
        }
        return $n;
    }

    public function setNombreArticles(?array $nombreArticles): self
    {
        $this->nombreArticles = $nombreArticles;

        return $this;
    }
}