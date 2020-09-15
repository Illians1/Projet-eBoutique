<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PanierRepository::class)
 */
class Panier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Articles::class)
     */
    private $Articles;

    public function __construct()
    {
        $this->Articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Articles[]
     */
    public function getArticles(): Collection
    {
        return $this->Articles;
    }

    public function addArticle(Articles $article): self
    {
        if (!$this->Articles->contains($article)) {
            $this->Articles[] = $article;
        }

        return $this;
    }

    public function removeArticle(Articles $article): self
    {
        if ($this->Articles->contains($article)) {
            $this->Articles->removeElement($article);
        }

        return $this;
    }
}
