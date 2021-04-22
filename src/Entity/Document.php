<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRepository")
 *
 */
class Document
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
     * @ORM\OneToMany(targetEntity="App\Entity\Comprendre", mappedBy="document")
     * @ORM\JoinColumn(nullable=false)
     */
    private $comprendres;

    public function __construct()
    {
        $this->comprendres = new ArrayCollection();
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

    public function getEvaluationEntretien(): ?EvaluationEntretien
    {
        return $this->evaluationEntretien;
    }

    public function setEvaluationEntretien(?EvaluationEntretien $evaluationEntretien): self
    {
        $this->evaluationEntretien = $evaluationEntretien;

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
            $comprendre->setDocument($this);
        }
        return $this;
    }

    public function removeComprendre(Comprendre $comprendre): self
    {
        if ($this->comprendres->contains($comprendre)) {
            $this->comprendres->removeElement($comprendre);
            // set the owning side to null (unless already changed)
            if ($comprendre->getDocument() === $this) {
                $comprendre->setDocument(null);
            }
        }
        return $this;
    }
}