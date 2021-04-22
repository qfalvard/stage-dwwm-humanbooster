<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CritereEvaluationStageRepository")
 *
 */
class CritereEvaluationStage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $intitule;

    /**
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\EvaluerStage", mappedBy="critereEvaluationStage")
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

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

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
            $evaluerStage->setCritereEvaluationStage($this);
        }

        return $this;
    }

    public function removeEvaluerStage(EvaluerStage $evaluerStage): self
    {
        if ($this->evaluerStages->contains($evaluerStage)) {
            $this->evaluerStages->removeElement($evaluerStage);
            // set the owning side to null (unless already changed)
            if ($evaluerStage->getCritereEvaluationStage() === $this) {
                $evaluerStage->setCritereEvaluationStage(null);
            }
        }

        return $this;
    }
  
}