<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CritereEntretienRepository")
 *
 */
class CritereEntretien
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
     * @ORM\OneToMany(targetEntity="App\Entity\EvaluationEntretien", mappedBy="critereEvaluation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $evaluationEntretiens;

    public function __construct()
    {
        $this->evaluationEntretiens = new ArrayCollection(); 
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
     * @return Collection|EvaluationEntretien[]
     */
    public function getEvaluationEntretien(): Collection
    {
        return $this->evaluationEntretiens;
    }

    public function addEvaluationEntretien(EvaluationEntretien $evaluationEntretien): void
    {
        if (!$this->evaluationEntretiens->contains($evaluationEntretien)) {
            $this->evaluationEntretienevaluationEntretiens[] = $evaluationEntretien;
            $evaluationEntretien->setCritereEntretien($this);
        }
    }

    public function removeEvaluationEntretien(EvaluationEntretien $evaluationEntretien): void
    {
        if ($this->evaluationEntretiens->contains($evaluationEntretien)) {
            $this->evaluationEntretiens->removeElement($evaluationEntretien);
            // set the owning side to null (unless already changed)
            if ($evaluationEntretien->getCritereEntretien() === $this) {
                $evaluationEntretien->setCritereEntretien(null);
            }
        }
    }
  
}