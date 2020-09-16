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

    public function addArticle(Articles $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
        }

        return $this;
    }

    public function removeArticle(Articles $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
        }

        return $this;
    }

    public function getTotal()
    {
        $sum = 0;
        foreach ($this->articles as $value) {
            $sum = $sum + $value->getPrixarticle();
        }
        return $sum;
    }

    public function checkSame()
    {
    }

    public function getNombreArticles(): ?array
    {
        return $this->nombreArticles;
    }

    public function setNombreArticles(?array $nombreArticles): self
    {
        $this->nombreArticles = $nombreArticles;

        return $this;
    }
}