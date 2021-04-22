<?php

namespace App\Entity;

use App\Repository\EntretienRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntretienRepository::class)
 */
class Entretien
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $estPresentiel;

    /**
     * @ORM\Column(type="text")
     */
    private $actionsRealisees;

    /**
     * @ORM\Column(type="text")
     */
    private $competencesTechniques;

    /**
     * @ORM\Column(type="text")
     */
    private $stagiairePointsForts;

    /**
     * @ORM\Column(type="text")
     */
    private $stagiairePointsAmelioration;

    /**
     * @ORM\Column(type="text")
     */
    private $tuteurPointsForts;

    /**
     * @ORM\Column(type="text")
     */
    private $tuteurPointsAmelioration;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEmbaucheEnvisager;

    /**
     * @ORM\Column(type="text")
     */
    private $commentaireEmbauche;

    /**
     * @ORM\Column(type="text")
     */
    private $commentaireGeneral;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EvaluationEntretien", mappedBy="entretien")
     * @ORM\JoinColumn(nullable=false)
     */
    private $evaluationEntretiens;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comprendre", mappedBy="entretien")
     * @ORM\JoinColumn(nullable=false)
     */
    private $comprendres;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Stage", inversedBy="entretien", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $stage;

    public function __construct()
    {
        $this->evaluationEntretiens = new ArrayCollection();
        $this->comprendres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEstPresentiel(): ?bool
    {
        return $this->estPresentiel;
    }

    public function setEstPresentiel(bool $estPresentiel): self
    {
        $this->estPresentiel = $estPresentiel;

        return $this;
    }

    public function getActionsRealisees(): ?string
    {
        return $this->actionsRealisees;
    }

    public function setActionsRealisees(string $actionsRealisees): self
    {
        $this->actionsRealisees = $actionsRealisees;

        return $this;
    }

    public function getCompetencesTechniques(): ?string
    {
        return $this->competencesTechniques;
    }

    public function setCompetencesTechniques(string $competencesTechniques): self
    {
        $this->competencesTechniques = $competencesTechniques;

        return $this;
    }

    public function getStagiairePointsForts(): ?string
    {
        return $this->stagiairePointsForts;
    }

    public function setStagiairePointsForts(string $stagiairePointsForts): self
    {
        $this->stagiairePointsForts = $stagiairePointsForts;

        return $this;
    }

    public function getStagiairePointsAmelioration(): ?string
    {
        return $this->stagiairePointsAmelioration;
    }

    public function setStagiairePointsAmelioration(string $stagiairePointsAmelioration): self
    {
        $this->stagiairePointsAmelioration = $stagiairePointsAmelioration;

        return $this;
    }

    public function getTuteurPointsForts(): ?string
    {
        return $this->tuteurPointsForts;
    }

    public function setTuteurPointsForts(string $tuteurPointsForts): self
    {
        $this->tuteurPointsForts = $tuteurPointsForts;

        return $this;
    }

    public function getTuteurPointsAmelioration(): ?string
    {
        return $this->tuteurPointsAmelioration;
    }

    public function setTuteurPointsAmelioration(string $tuteurPointsAmelioration): self
    {
        $this->tuteurPointsAmelioration = $tuteurPointsAmelioration;

        return $this;
    }

    public function getIsEmbaucheEnvisager(): ?bool
    {
        return $this->isEmbaucheEnvisager;
    }

    public function setIsEmbaucheEnvisager(bool $isEmbaucheEnvisager): self
    {
        $this->isEmbaucheEnvisager = $isEmbaucheEnvisager;

        return $this;
    }

    public function getCommentaireEmbauche(): ?string
    {
        return $this->commentaireEmbauche;
    }

    public function setCommentaireEmbauche(string $commentaireEmbauche): self
    {
        $this->commentaireEmbauche = $commentaireEmbauche;

        return $this;
    }

    public function getCommentaireGeneral(): ?string
    {
        return $this->commentaireGeneral;
    }

    public function setCommentaireGeneral(string $commentaireGeneral): self
    {
        $this->commentaireGeneral = $commentaireGeneral;

        return $this;
    }

    /**
     * @return Collection|EvaluationEntretien[]
     */
    public function getEvaluationEntretiens(): Collection
    {
        return $this->evaluationEntretiens;
    }

    public function addEvaluationEntretien(EvaluationEntretien $evaluationEntretien): self
    {
        if (!$this->evaluationEntretiens->contains($evaluationEntretien)) {
            $this->evaluationEntretiens[] = $evaluationEntretien;
            $evaluationEntretien->setEntretien($this);
        }

        return $this;
    }

    public function removeEvaluationEntretien(EvaluationEntretien $evaluationEntretien): self
    {
        if ($this->evaluationEntretiens->contains($evaluationEntretien)) {
            $this->evaluationEntretiens->removeElement($evaluationEntretien);
            // set the owning side to null (unless already changed)
            if ($evaluationEntretien->getEntretien() === $this) {
                $evaluationEntretien->setEntretien(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|Comprendre[]
     */
    public function getComprendres(): Collection
    {
        return $this->comprendres;
    }

    public function addComprendre(Comprendre $comprendre): self
    {
        if (!$this->comprendres->contains($comprendre)) {
            $this->comprendres[] = $comprendre;
            $comprendre->setEntretien($this);
        }

        return $this;
    }

    public function removeComprendre(Comprendre $comprendre): self
    {
        if ($this->comprendres->contains($comprendre)) {
            $this->comprendres->removeElement($comprendre);
            // set the owning side to null (unless already changed)
            if ($comprendre->getEntretien() === $this) {
                $comprendre->setEntretien(null);
            }
        }

        return $this;
    }

    public function getStage(): Stage
    {
        return $this->stage;
    }
 
    public function setStage(Stage $stage): self
    {
        $this->stage = $stage;
 
        return $this;
    }
}
