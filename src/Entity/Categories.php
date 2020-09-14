<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categories
 *
 * @ORM\Table(name="categories")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\CategoriesRepository")
 */
class Categories
{
    /**
     * @var int
     *
     * @ORM\Column(name="idCategorie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcategorie;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nomCategorie", type="string", length=40, nullable=true)
     */
    private $nomcategorie;

    public function getIdcategorie(): ?int
    {
        return $this->idcategorie;
    }

    public function getNomcategorie(): ?string
    {
        return $this->nomcategorie;
    }

    public function setNomcategorie(?string $nomcategorie): self
    {
        $this->nomcategorie = $nomcategorie;

        return $this;
    }

}
