<?php

namespace App\Entity;

use App\Entity\Categories;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Articles
 *
 * @ORM\Table(name="articles", indexes={@ORM\Index(name="fk_category", columns={"idCategorie"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ArticlesRepository")
 */
class Articles
{
    /**
     * @var int
     *
     * @ORM\Column(name="idArticle", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idarticle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nomArticle", type="string", length=20, nullable=true)
     */
    private $nomarticle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="imageArticle", type="string", length=40, nullable=true)
     */
    private $imagearticle;

    /**
     * @var float|null
     *
     * @ORM\Column(name="prixArticle", type="float", precision=10, scale=0, nullable=true)
     */
    private $prixarticle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descriptionArticle", type="string", length=200, nullable=true)
     */
    private $descriptionarticle;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="vidArticle", type="string", length=30, nullable=false)
     */
    private $vidarticle;

    /**
     * @var \Categories
     *
     * @ORM\ManyToOne(targetEntity="Categories")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="idCategorie", referencedColumnName="idCategorie")
     * })
     */
    private $idcategorie;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Commandes", mappedBy="idarticle")
     */
    private $idcommande;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idcommande = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdarticle(): ?int
    {
        return $this->idarticle;
    }

    public function getNomarticle(): ?string
    {
        return $this->nomarticle;
    }

    public function setNomarticle(?string $nomarticle): self
    {
        $this->nomarticle = $nomarticle;

        return $this;
    }

    public function getImagearticle(): ?string
    {
        return $this->imagearticle;
    }

    public function setImagearticle(?string $imagearticle): self
    {
        $this->imagearticle = $imagearticle;

        return $this;
    }

    public function getPrixarticle(): ?float
    {
        return $this->prixarticle;
    }

    public function setPrixarticle(?float $prixarticle): self
    {
        $this->prixarticle = $prixarticle;

        return $this;
    }

    public function getDescriptionarticle(): ?string
    {
        return $this->descriptionarticle;
    }

    public function setDescriptionarticle(?string $descriptionarticle): self
    {
        $this->descriptionarticle = $descriptionarticle;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getVidarticle(): ?string
    {
        return $this->vidarticle;
    }

    public function setVidarticle(string $vidarticle): self
    {
        $this->vidarticle = $vidarticle;

        return $this;
    }

    public function getIdcategorie(): ?Categories
    {
        return $this->idcategorie;
    }

    public function setIdcategorie(?Categories $idcategorie): self
    {
        $this->idcategorie = $idcategorie;

        return $this;
    }

    /**
     * @return Collection|Commandes[]
     */
    public function getIdcommande(): Collection
    {
        return $this->idcommande;
    }

    public function addIdcommande(Commandes $idcommande): self
    {
        if (!$this->idcommande->contains($idcommande)) {
            $this->idcommande[] = $idcommande;
            $idcommande->addIdarticle($this);
        }

        return $this;
    }

    public function removeIdcommande(Commandes $idcommande): self
    {
        if ($this->idcommande->contains($idcommande)) {
            $this->idcommande->removeElement($idcommande);
            $idcommande->removeIdarticle($this);
        }

        return $this;
    }
}
