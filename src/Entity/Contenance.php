<?php

namespace App\Entity;

use App\Repository\ContenanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContenanceRepository::class)]
class Contenance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    private $quantite;

    #[ORM\Column(type: 'string', length: 255)]
    private $unite;

    #[ORM\Column(type: 'float', nullable: true)]
    private $prix;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $stock;

    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'contenances')]
    private $produit;

    #[ORM\OneToMany(mappedBy: 'contenance', targetEntity: CommandeProduit::class)]
    private $commandeProduits;

    public function __construct()
    {
        $this->commandeProduits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(string $unite): self
    {
        $this->unite = $unite;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function increaseStock(int $stock) : self
    {
        $this->stock += $stock;

        return $this;
    }
    
    public function decrementStock(int $stock) : self
    {
        $this->stock -= $stock;

        return $this;
    }
    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

        return $this;
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

    /**
     * @return Collection<int, CommandeProduit>
     */
    public function getCommandeProduits(): Collection
    {
        return $this->commandeProduits;
    }

    public function addCommandeProduit(CommandeProduit $commandeProduit): self
    {
        if (!$this->commandeProduits->contains($commandeProduit)) {
            $this->commandeProduits[] = $commandeProduit;
            $commandeProduit->setContenance($this);
        }

        return $this;
    }

    public function removeCommandeProduit(CommandeProduit $commandeProduit): self
    {
        if ($this->commandeProduits->removeElement($commandeProduit)) {
            // set the owning side to null (unless already changed)
            if ($commandeProduit->getContenance() === $this) {
                $commandeProduit->setContenance(null);
            }
        }

        return $this;
    }
}
