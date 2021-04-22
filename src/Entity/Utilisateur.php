<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 * @UniqueEntity(fields={"email"}, message="Cette adresse mail existe déjà dans la base de données !")
 */
class Utilisateur implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActif;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $tokenCreatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $confirmationToken;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $reset_token;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $tokenMailCreatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evaluation", mappedBy="utilisateur")
     */
    private $evaluations;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Session", mappedBy="stagiaires")
     */
    private $sessions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Former", mappedBy="formateur")
     */
    private $formers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Encadrer", mappedBy="encadrant")
     */
    private $encadrers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RechercheStage", mappedBy="utilisateur")
     */
    private $rechercheStages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RechercheStage", mappedBy="stagiaire")
     */
    private $stagesStagiaire;
        /**
     * @ORM\OneToMany(targetEntity="App\Entity\RechercheStage", mappedBy="tuteur")
     */
    private $stagesTuteur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RechercheStage", mappedBy="proContact")
     */
    private $contactStages;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entreprise", inversedBy="utilisateurs")
     * @ORM\JoinColumn(nullable=true)
     */
    private $entreprises;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Adresse", inversedBy="utilisateurs")
     * @ORM\JoinColumn(nullable=true)
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity=Evaluation::class, mappedBy="formateur")
     */
    private $evaluationsFormateur;

    public function __construct()
    {
        $this->role = new ArrayCollection();
        $this->evaluations = new ArrayCollection();
        $this->sessions = new ArrayCollection();
        $this->formers = new ArrayCollection();
        $this->encadrers = new ArrayCollection();
        $this->rechercheStages = new ArrayCollection();
        $this->stagesStagiaire = new ArrayCollection();
        $this->stagesTuteur = new ArrayCollection();
        $this->evaluationsFormateur = new ArrayCollection();
        $this->contactStages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) ucfirst($this->prenom);
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getTokenCreatedAt(): ?\DateTimeInterface
    {
        return $this->tokenCreatedAt;
    }

    public function setTokenCreatedAt(?\DateTimeInterface $tokenCreatedAt): self
    {
        $this->tokenCreatedAt = $tokenCreatedAt;

        return $this;
    }

    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken(?string $confirmationToken): self
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    public function getIsActif(): ?bool
    {
        return $this->isActif;
    }

    public function setIsActif(bool $isActif): self
    {
        $this->isActif = $isActif;

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->reset_token;
    }

    public function setResetToken(?string $reset_token): self
    {
        $this->reset_token = $reset_token;

        return $this;
    }

    public function getTokenMailCreatedAt(): ?\DateTimeInterface
    {
        return $this->tokenMailCreatedAt;
    }

    public function setTokenMailCreatedAt(?\DateTimeInterface $tokenMailCreatedAt): self
    {
        $this->tokenMailCreatedAt = $tokenMailCreatedAt;

        return $this;
    }

    /**
     * @return Collection|Evaluation[]
     */
    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function addEvaluation(Evaluation $evaluation): void
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations[] = $evaluation;
            $evaluation->setUtilisateur($this);
        }
    }

    public function removeEvaluation(Evaluation $evaluation): void
    {
        if ($this->evaluations->contains($evaluation)) {
            $this->evaluations->removeElement($evaluation);
            // set the owning side to null (unless already changed)
            if ($evaluation->getUtilisateur() === $this) {
                $evaluation->setUtilisateur(null);
            }
        }
    }

    /**
     * @return Collection|Session[]
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->addStagiaire($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->contains($session)) {
            $this->sessions->removeElement($session);
            $session->removeStagiaire($this);
        }

        return $this;
    }

    /**
     * @return Collection|Former[]
     */
    public function getFormers(): Collection
    {
        return $this->formers;
    }

    public function addFormer(Former $former): self
    {
        if (!$this->formers->contains($former)) {
            $this->formers[] = $former;
            $former->setFormateur($this);
        }

        return $this;
    }

    public function removeFormer(Former $former): self
    {
        if ($this->formers->contains($former)) {
            $this->formers->removeElement($former);
            // set the owning side to null (unless already changed)
            if ($former->getFormateur() === $this) {
                $former->setFormateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Encadrer[]
     */
    public function getEncadrers(): Collection
    {
        return $this->encadrers;
    }

    public function addEncadrer(Encadrer $encadrer): self
    {
        if (!$this->encadrers->contains($encadrer)) {
            $this->encadrers[] = $encadrer;
            $encadrer->setEncadrant($this);
        }

        return $this;
    }

    public function removeEncadrer(Encadrer $encadrer): self
    {
        if ($this->encadrers->contains($encadrer)) {
            $this->encadrers->removeElement($encadrer);
            // set the owning side to null (unless already changed)
            if ($encadrer->getEncadrant() === $this) {
                $encadrer->setEncadrant(null);
            }
        }

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
            $rechercheStage->setUtilisateur($this);
        }
    }

    public function removeRechercheStage(RechercheStage $rechercheStage): void
    {
        if ($this->rechercheStages->contains($rechercheStage)) {
            $this->rechercheStages->removeElement($rechercheStage);
            // set the owning side to null (unless already changed)
            if ($rechercheStage->getUtilisateur() === $this) {
                $rechercheStage->setUtilisateur(null);
            }
        }
    }
    /**
     * @return Collection|Stage[]
     */
    public function getStagesStagiaire(): Collection
    {
        return $this->stagesStagiaire;
    }

    public function addStageStagiaire(Stage $stageStagiaire): void
    {
        if (!$this->stagesStagiaire->contains($stageStagiaire)) {
            $this->stagesStagiaire[] = $stageStagiaire;
            $stageStagiaire->setUtilisateur($this);
        }
    }

    public function removeStageStagiaire(Stage $stageStagiaire): void
    {
        if ($this->stagesStagiaire->contains($stageStagiaire)) {
            $this->stagesStagiaire->removeElement($stageStagiaire);
            // set the owning side to null (unless already changed)
            if ($stageStagiaire->getUtilisateur() === $this) {
                $stageStagiaire->setUtilisateur(null);
            }
        }
    }

        /**
     * @return Collection|Stage[]
     */
    public function getStagesTuteur(): Collection
    {
        return $this->stagesTuteur;
    }

    public function addStageTuteur(Stage $stageTuteur): void
    {
        if (!$this->stagesTuteur->contains($stageTuteur)) {
            $this->stagesTuteur[] = $stageTuteur;
            $stageTuteur->setUtilisateur($this);
        }
    }

    public function removeStageTuteur(Stage $stageTuteur): void
    {
        if ($this->stagesTuteur->contains($stageTuteur)) {
            $this->stagesTuteur->removeElement($stageTuteur);
            // set the owning side to null (unless already changed)
            if ($stageTuteur->getUtilisateur() === $this) {
                $stageTuteur->setUtilisateur(null);
            }
        }
    }
    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprises;
    }

    public function setEntreprise(?Entreprise $entreprises): self
    {
        $this->entreprises = $entreprises;

        return $this;
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }
    public function __toString()
    {
        
        return $this->getNom() . ' ' . $this->getPrenom();
    }

    /**
     * @return Collection|Evaluation[]
     */
    public function getEvaluationsFormateur(): Collection
    {
        return $this->evaluationsFormateur;
    }

    public function addEvaluationsFormateur(Evaluation $evaluationsFormateur): self
    {
        if (!$this->evaluationsFormateur->contains($evaluationsFormateur)) {
            $this->evaluationsFormateur[] = $evaluationsFormateur;
            $evaluationsFormateur->setFormateur($this);
        }

        return $this;
    }

    public function removeEvaluationsFormateur(Evaluation $evaluationsFormateur): self
    {
        if ($this->evaluationsFormateur->contains($evaluationsFormateur)) {
            $this->evaluationsFormateur->removeElement($evaluationsFormateur);
            // set the owning side to null (unless already changed)
            if ($evaluationsFormateur->getFormateur() === $this) {
                $evaluationsFormateur->setFormateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RechercheStage[]
     */
    public function getContactStages(): Collection
    {
        return $this->contactStages;
    }

    public function addContactStage(RechercheStage $contactStage): self
    {
        if (!$this->contactStages->contains($contactStage)) {
            $this->contactStages[] = $contactStage;
            $contactStage->setRechercheStage($this);
        }

        return $this;
    }

    public function removeContactStage(RechercheStage $contactStage): self
    {
        if ($this->contactStages->contains($contactStage)) {
            $this->contactStages->removeElement($contactStage);
            // set the owning side to null (unless already changed)
            if ($contactStage->getRechercheStage() === $this) {
                $contactStage->setRechercheStage(null);
            }
        }

        return $this;
    }
}
