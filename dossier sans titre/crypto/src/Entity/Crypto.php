<?php

namespace App\Entity;

use App\Repository\CryptoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CryptoRepository::class)
 */
class Crypto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Symbole;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateCreation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Createur;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $Minable;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="crypto")
     */
    private $commentaires;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="mesCryptos")
     */
    private $users;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(?string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getSymbole(): ?string
    {
        return $this->Symbole;
    }

    public function setSymbole(?string $Symbole): self
    {
        $this->Symbole = $Symbole;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->DateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $DateCreation): self
    {
        $this->DateCreation = $DateCreation;

        return $this;
    }

    public function getCreateur(): ?string
    {
        return $this->Createur;
    }

    public function setCreateur(?string $Createur): self
    {
        $this->Createur = $Createur;

        return $this;
    }

    public function getMinable(): ?string
    {
        return $this->Minable;
    }

    public function setMinable(?string $Minable): self
    {
        $this->Minable = $Minable;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setCrypto($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getCrypto() === $this) {
                $commentaire->setCrypto(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addMesCrypto($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeMesCrypto($this);
        }

        return $this;
    }



}
