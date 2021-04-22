<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\EvaluerStageRepository")
 *
 */
class EvaluerStage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $note;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\EvaluationStage", inversedBy="evaluerStages", cascade={"persist"})
     */
    private $evaluationStage;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\CritereEvaluationStage", inversedBy="evaluerStages", cascade={"persist"})
     */
    private $critereEvaluationStage;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;

        return $this;
    }
    
    public function getCritereEvaluationStage(): ?CritereEvaluationStage
    {
        return $this->critereEvaluationStage;
    }

    public function setCritereEvaluationStage(?CritereEvaluationStage $critereEvaluationStage): self
    {
        $this->critereEvaluationStage = $critereEvaluationStage;

        return $this;
    }

    public function getEvaluationStage(): ?EvaluationStage
    {
        return $this->evaluationStage;
    }

    public function setEvaluationStage(?EvaluationStage $evaluationStage): self
    {
        $this->evaluationStage = $evaluationStage;

        return $this;
    }
}