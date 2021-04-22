<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EvaluationRepository")
 */
class Evaluation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Assert\LessThanOrEqual("today")
     */
    private $date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $niveauAcquisition;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Objectif")
     * @ORM\JoinColumn(nullable=false)
     */
    private $objectif;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Module")
     * @ORM\JoinColumn(nullable=false)
     */
    private $module;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="evaluations")
     */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="evaluationsFormateur")
     */
    private $formateur;
    
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

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getNiveauAcquisition(): ?int
    {
        return $this->niveauAcquisition;
    }

    public function setNiveauAcquisition(?int $niveauAcquisition): self
    {
        $this->niveauAcquisition = $niveauAcquisition;

        return $this;
    }

    public function getObjectif(): ?Objectif
    {
        return $this->objectif;
    }

    public function setObjectif(?Objectif $objectif): self
    {
        $this->objectif = $objectif;

        return $this;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): self
    {
        $this->module = $module;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getFormateur(): ?Utilisateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Utilisateur $formateur): self
    {
        $this->formateur = $formateur;

        return $this;
    }
    
}
