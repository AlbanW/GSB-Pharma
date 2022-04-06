<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $illustration;

    #[ORM\ManyToOne(targetEntity: Marque::class, inversedBy: 'produits')]
    private $marque;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Note::class)]
    private $notes;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'produits')]
    private $category;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Contenance::class)]
    private $contenances;



    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->contenances = new ArrayCollection();
    }


    public function getResume() : ?string
    {
        $max = 65;
        $chaine = $this->description;
        if (strlen($chaine) >= $max)
        {
        $chaine = substr($chaine, 0, $max);
        $espace = strrpos($chaine, " ");
        $chaine = substr($chaine, 0, $espace)."...";
        }
        return $chaine;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(string $illustration): self
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function getLowPrice() : float
    {
        $low = 0;
        foreach($this->getContenances() as $contenance)
        {
            if($contenance->getPrix() > $low) 
                $low = $contenance->getPrix();
        }
        return $low;
    }

    public function getAverageNote() : int 
    {
        $totalNote = 0;
        $sumNote = 0;
        foreach($this->getNotes() as $note)
        {
            $sumNote += $note->getNote();
            $totalNote++;
        }
        return ($sumNote / $totalNote);
    }

    public function getTotalNotes() : int 
    {
        return count($this->getNotes());
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setProduit($this);
        }

        return $this;
    }

    public function haveStock() : ?bool
    {
        foreach($this->getContenances() as $contenance)
            if($contenance->getStock() != null && $contenance->getStock() > 0) return true;
        return false;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getProduit() === $this) {
                $note->setProduit(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Categorie
    {
        return $this->category;
    }

    public function setCategory(?Categorie $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Contenance>
     */
    public function getContenances(): Collection
    {
        return $this->contenances;
    }

    public function addContenance(Contenance $contenance): self
    {
        if (!$this->contenances->contains($contenance)) {
            $this->contenances[] = $contenance;
            $contenance->setProduit($this);
        }

        return $this;
    }

    public function removeContenance(Contenance $contenance): self
    {
        if ($this->contenances->removeElement($contenance)) {
            // set the owning side to null (unless already changed)
            if ($contenance->getProduit() === $this) {
                $contenance->setProduit(null);
            }
        }

        return $this;
    }




}
