<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;




/**
 * @ORM\Entity(repositoryClass="App\Repository\RechercheStageRepository")
 *
 */
class RechercheStage 
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaireStagiaire;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaireHB;
    /**
     * @ORM\Column(type="text")
     */
    private $detail;

    /**
     * @ORM\Column(type="boolean")
     */
    private $reponse;

    /**
     * @ORM\Column(type="datetime")
     * 
     */
    private $date;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="rechercheStages")
     */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="contactStages", cascade={"persist"})
     */
    private $proContact;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entreprise", inversedBy="rechercheStages", cascade={"persist"})
     */
    private $entreprise;

    public function __construct()
    {
        $this->date = new \DateTime();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaireStagiaire(): ?string
    {
        return $this->commentaireStagiaire;
    }

    public function setCommentaireStagiaire(string $commentaireStagiaire): self
    {
        $this->commentaireStagiaire = $commentaireStagiaire;

        return $this;
    }

    public function getCommentaireHB(): ?string
    {
        return $this->commentaireHB;
    }

    public function setCommentaireHB(string $commentaireHB): self
    {
        $this->commentaireHB = $commentaireHB;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): self
    {
        $this->detail = $detail;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getReponse(): ?bool
    {
        return $this->reponse;
    }

    public function setReponse(bool $reponse): self
    {
        $this->reponse = $reponse;

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

    public function getProContact(): ?Utilisateur
    {
        return $this->proContact;
    }

    public function setProContact(?Utilisateur $proContact): self
    {
        $this->proContact = $proContact;

        return $this;
    }
}