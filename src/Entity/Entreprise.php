<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;




/**
 * @ORM\Entity(repositoryClass="App\Repository\EntrepriseRepository")
 *
 */
class Entreprise
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $raisonSocial;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;


    /**
     * @ORM\Column(type="string", length=10)
     */
    private $telephone;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $activite;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RechercheStage", mappedBy="entreprise")
     */
    private $rechercheStages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Utilisateur", mappedBy="entreprises")
     */
    private $utilisateurs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Adresse", inversedBy="entreprises", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresse;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RechercheStage", mappedBy="utilisateur")
     */
    private $stages;
    public function __construct()
    {
        $this->rechercheStages = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
        $this->stages = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRaisonSocial(): ?string
    {
        return $this->raisonSocial;
    }

    public function setRaisonSocial(string $raisonSocial): self
    {
        $this->raisonSocial = $raisonSocial;

        return $this;
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


    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(string $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

     

    /**
     * @return Collection|RechercheStage[]
     */
    public function getRechercheStages(): Collection
    {
        return $this->rechercheStages;
    }

    public function addRechercheStage(RechercheStage $rechercheStage): void
    {
        if (!$this->rechercheStages->contains($rechercheStage)) {
            $this->rechercheStages[] = $rechercheStage;
            $rechercheStage->setEntreprise($this);
        }
    }

    public function removeRechercheStage(RechercheStage $rechercheStage): void
    {
        if ($this->rechercheStages->contains($rechercheStage)) {
            $this->rechercheStages->removeElement($rechercheStage);
            // set the owning side to null (unless already changed)
            if ($rechercheStage->getEntreprise() === $this) {
                $rechercheStage->setEntreprise(null);
            }
        }
    }
    /**
     * @return Collection|Utilisateur[]
     */
    public function geUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): void
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs[] = $utilisateur;
            $utilisateur->setEntreprise($this);
        }
    }

    public function removeUtilisateur(Utilisateur $utilisateur): void
    {
        if ($this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->removeElement($utilisateur);
            // set the owning side to null (unless already changed)
            if ($utilisateur->getEntreprise() === $this) {
                $utilisateur->setEntreprise(null);
            }
        }
    }
    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

       /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): void
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->setEntreprise($this);
        }
    }

    public function removeStage(Stage $stage): void
    {
        if ($this->stages->contains($stage)) {
            $this->stages->removeElement($stage);
            // set the owning side to null (unless already changed)
            if ($stage->getEntreprise() === $this) {
                $stage->setEntreprise(null);
            }
        }
    }
    public function __toString()
    {
        
        return $this->nom;
    }
}