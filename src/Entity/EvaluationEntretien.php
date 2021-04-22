<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\EvaluationEntretienRepository")
 *
 */
class EvaluationEntretien
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Entretien", inversedBy="evaluationEntretiens", cascade={"persist"})
     */
    private $entretien;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\CritereEntretien", inversedBy="evaluationEntretiens", cascade={"persist"})
     */
    private $critereEntretien;


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
    
    public function getEntretien(): ?Entretien
    {
        return $this->entretien;
    }

    public function setEntretien(?Entretien $entretien): self
    {
        $this->entretien = $entretien;

        return $this;
    }

    public function getCritereEntretien(): ?CritereEntretien
    {
        return $this->critereEntretien;
    }

    public function setCritereEntretien(?CritereEntretien $critereEntretien): self
    {
        $this->critereEntretien = $critereEntretien;

        return $this;
    }
}