<?php

namespace App\Entity;

use App\Repository\EvaluationStageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvaluationStageRepository::class)
 */
class EvaluationStage
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
    private $lien;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateLien;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEvaluation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateMailConfirmation;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Stage", inversedBy="evaluationStage", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $stage;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EvaluerStage", mappedBy="evaluationStage")
     * @ORM\JoinColumn(nullable=false)
     */
    private $evaluerStages;

    public function __construct()
    {
        $this->evaluerStages = new ArrayCollection(); 
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    public function getDateLien(): ?\DateTimeInterface
    {
        return $this->dateLien;
    }

    public function setDateLien(\DateTimeInterface $dateLien): self
    {
        $this->dateLien = $dateLien;

        return $this;
    }

    public function getDateEvaluation(): ?\DateTimeInterface
    {
        return $this->dateEvaluation;
    }

    public function setDateEvaluation(\DateTimeInterface $dateEvaluation): self
    {
        $this->dateEvaluation = $dateEvaluation;

        return $this;
    }

    public function getDateMailConfirmation(): ?\DateTimeInterface
    {
        return $this->dateMailConfirmation;
    }

    public function setDateMailConfirmation(\DateTimeInterface $dateMailConfirmation): self
    {
        $this->dateMailConfirmation = $dateMailConfirmation;

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

      /**
     * @return Collection|EvaluerStage[]
     */
    public function getEvaluerStages(): Collection
    {
        return $this->evaluerStages;
    }

    public function addEvaluerStage(EvaluerStage $evaluerStage): self
    {
        if (!$this->evaluerStages->contains($evaluerStage)) {
            $this->evaluerStages[] = $evaluerStage;
            $evaluerStage->setEvaluationStage($this);
        }

        return $this;
    }

    public function removeEvaluerStage(EvaluerStage $evaluerStage): self
    {
        if ($this->evaluerStages->contains($evaluerStage)) {
            $this->evaluerStages->removeElement($evaluerStage);
            // set the owning side to null (unless already changed)
            if ($evaluerStage->getEvaluationStage() === $this) {
                $evaluerStage->setEvaluationStage(null);
            }
        }

        return $this;
    }
}
