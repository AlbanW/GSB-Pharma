<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[UniqueEntity(fields:"mail", message:"Ce mail est déjà utilisé pour un autre compte")]
#[UniqueEntity(fields: ['mail'], message: 'There is already an account with this mail')]
class Client implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $mail;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotNull]
    private $nom;

    #[Assert\NotNull]
    #[ORM\Column(type: 'string', length: 255)]
    private $prenom;

    #[Assert\NotNull]
    #[ORM\Column(type: 'string', length: 255)]
    private $adresse;

    #[Assert\NotNull]
    #[ORM\Column(type: 'string', length: 255)]
    private $ville;

    #[Assert\NotNull]
    #[ORM\Column(type: 'string', length: 255)]
    private $codePostal;

    #[Assert\NotNull]
    #[ORM\Column(type: 'string', length: 255)]
    private $telephone;

 

    #[Assert\NotNull]
    #[ORM\OneToMany(mappedBy: 'idClient', targetEntity: Note::class)]
    private $notes;


    #[ORM\Column(type: 'boolean')]
    private $acceptCgu;

    #[ORM\Column(type: 'datetime')]
    private $acceptCguDate;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class)]
    private $commandes;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->commandes = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }


    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setIdClient($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getIdClient() === $this) {
                $note->setIdClient(null);
            }
        }

        return $this;
    }

  

    public function acceptCgu(): ?bool
    {
        return $this->acceptCgu;
    }

    public function setAcceptCgu(bool $acceptCgu): self
    {
        $this->acceptCgu = $acceptCgu;

        return $this;
    }

    public function getAcceptCguDate(): ?\DateTimeInterface
    {
        return $this->acceptCguDate;
    }

    public function setAcceptCguDate(\DateTimeInterface $acceptCguDate): self
    {
        $this->acceptCguDate = $acceptCguDate;

        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->mail;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function haveRole($string)
    {
        foreach($this->roles as $role)
        {
            if($role == $string) return true;
        }
        return false;
    }

    public function updateRole($admin, $order, $stock, $salarie): self
    {
        $role = [];
        $role[] = 'ROLE_USER';
        if($admin == 1) $role[] = 'ROLE_ADMIN';
        if($salarie == 1) $role[] = 'ROLE_SALARIE';
        if($order == 1) $role[] = 'ROLE_ORDER';
        if($stock == 1) $role[] = 'ROLE_STOCK';

        $this->roles = $role;
        return $this;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function countCommandes() : ?int 
    {
        $count = 0;
        foreach($this->commandes as $commande)
        {
            if($commande->getStatus() == 1 || $commande->getStatus() == 0) $count++;
        }
        return $count;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }

  
}
