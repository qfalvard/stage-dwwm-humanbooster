<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SessionRepository")
 */
class Session
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
    private $intitule;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThan(propertyPath="dateDebut", message="La date de fin de formation doit être supérieure à la date de début de formation")
     */
    private $dateFin;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThan(propertyPath="dateDebut", message="La date de début de stage doit être supérieure à la date de début de formation")
     * @Assert\LessThan(propertyPath="dateFin", message="La date de début de stage doit être inférieure à la date de fin de formation")
     */
    private $debutStage;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThan(propertyPath="debutStage", message="La date de fin de stage doit être supérieure à la date de début de stage")
     * @Assert\LessThan(propertyPath="dateFin", message="La date de fin de stage doit être inférieure à la date de fin de formation")
     */
    private $finStage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Moodle;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActif;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TitreProfessionnel", inversedBy="sessions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $titreProfessionnel;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Utilisateur", inversedBy="sessions")
     * @ORM\JoinTable(name="participer")
     */
    private $stagiaires;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Former", mappedBy="session")
     */
    private $formers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Encadrer", mappedBy="session")
     */
    private $encadrers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Adresse", inversedBy="sessions")
     */
    private $adresse;

    public function __construct()
    {
        $year = date("Y");
        $date = $year . "-01-01";
        $this->dateDebut = new \DateTime($date);
        $this->dateFin = new \DateTime($date);
        $this->debutStage = new \DateTime($date);
        $this->finStage = new \DateTime($date);
        $this->stagiaires = new ArrayCollection();
        $this->formers = new ArrayCollection();
        $this->encadrers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getDebutStage(): ?\DateTimeInterface
    {
        return $this->debutStage;
    }

    public function setDebutStage(\DateTimeInterface $debutStage): self
    {
        $this->debutStage = $debutStage;

        return $this;
    }

    public function getFinStage(): ?\DateTimeInterface
    {
        return $this->finStage;
    }

    public function setFinStage(\DateTimeInterface $finStage): self
    {
        $this->finStage = $finStage;

        return $this;
    }

    public function getMoodle(): ?string
    {
        return $this->Moodle;
    }

    public function setMoodle(string $Moodle): self
    {
        $this->Moodle = $Moodle;

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

    public function getTitreProfessionnel(): ?TitreProfessionnel
    {
        return $this->titreProfessionnel;
    }

    public function setTitreProfessionnel(?TitreProfessionnel $titreProfessionnel): self
    {
        $this->titreProfessionnel = $titreProfessionnel;

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getStagiaires(): Collection
    {
        return $this->stagiaires;
    }

    public function addStagiaire(Utilisateur $stagiaire): self
    {
        if (!$this->stagiaires->contains($stagiaire)) {
            $this->stagiaires[] = $stagiaire;
        }

        return $this;
    }

    public function removeStagiaire(Utilisateur $stagiaire): self
    {
        if ($this->stagiaires->contains($stagiaire)) {
            $this->stagiaires->removeElement($stagiaire);
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
            $former->setSession($this);
        }

        return $this;
    }

    public function removeFormer(Former $former): self
    {
        if ($this->formers->contains($former)) {
            $this->formers->removeElement($former);
            // set the owning side to null (unless already changed)
            if ($former->getSession() === $this) {
                $former->setSession(null);
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
            $encadrer->setSession($this);
        }

        return $this;
    }

    public function removeEncadrer(Encadrer $encadrer): self
    {
        if ($this->encadrers->contains($encadrer)) {
            $this->encadrers->removeElement($encadrer);
            // set the owning side to null (unless already changed)
            if ($encadrer->getSession() === $this) {
                $encadrer->setSession(null);
            }
        }

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

    public function __toString()
    {
        return $this->getStagiaires();
    }
}
