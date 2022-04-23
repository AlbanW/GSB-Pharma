<?php

namespace App\Entity;

use App\Repository\RecommandationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecommandationRepository::class)]
class Recommandation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'recommandations')]
    private $produit;

    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'recommandations')]
    private $recommend;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getRecommend(): ?Produit
    {
        return $this->recommend;
    }

    public function setRecommend(?Produit $recommend): self
    {
        $this->recommend = $recommend;

        return $this;
    }
}
