<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\StageRepository")
 *
 */
class Stage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="datetime")
     * 
     */
    private $debutStage;

    /**
     * @ORM\Column(type="datetime")
     * 
     */
    private $finStage;
    /**
     * @ORM\Column(type="text")
     */
    private $mission;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entreprise", inversedBy="stage")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entreprise;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="stageStagiaire")
     * @ORM\JoinColumn(nullable=false)
     */
    private $stagiaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="stageTuteur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tuteur;
    /**
    * @ORM\OneToOne(targetEntity="App\Entity\EvaluationStage", mappedBy="stage", cascade={"persist", "remove"})
    */
    private $evaluationStage;

    /**
    * @ORM\OneToOne(targetEntity="App\Entity\Entretien", mappedBy="stage", cascade={"persist", "remove"})
    */
    private $entretien;
    


    public function __construct()
    {
        $this->debutStage = new \DateTime();
        $this->finStage = new \DateTime();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStagiaire(): ?Utilisateur
    {
        return $this->stagiaire;
    }

    public function setUtilisateur(?Utilisateur $stagiaire): self
    {
        $this->stagiaire = $stagiaire;

        return $this;
    }

    public function getTuteur(): ?Utilisateur
    {
        return $this->tuteur;
    }

    public function setTuteur(?Utilisateur $tuteur): self
    {
        $this->tuteur = $tuteur;

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }
    public function getMission(): ?string
    {
        return $this->mission;
    }

    public function setMission(string $mission): self
    {
        $this->mission = $mission;

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
    public function getEntretien(): Entretien
    {
        return $this->entretien;
    }
 
    public function setEntretien(Entretien $entretien): self
    {
        $this->entretien = $entretien;
 
        return $this;
    }

    public function getEvaluationStage(): EvaluationStage
    {
        return $this->evaluationStage;
    }
 
    public function setEvaluationStage(EvaluationStage $evaluationStage): self
    {
        $this->evaluationStage = $evaluationStage;
 
        return $this;
    }
}