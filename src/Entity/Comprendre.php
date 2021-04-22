<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ComprendreRepository")
 *
 */
class Comprendre
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $avancee;

    /**
     * @ORM\Column(type="text")
     */
    private $commentaire;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\Entretien", inversedBy="comprendres", cascade={"persist"})
     */
    private $entretien;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\Document", inversedBy="comprendres", cascade={"persist"})
     * 
     */
    private $document;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvancee(): ?integer
    {
        return $this->avancee;
    }

    public function setAvancee(Integer $avancee): self
    {
        $this->avancee = $avancee;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getEntretien(): ?string
    {
        return $this->entretien;
    }

    public function setEntretien(string $entretien): self
    {
        $this->entretien = $entretien;

        return $this;
    }
   
    public function getDocument(): ?string
    {
        return $this->document;
    }

    public function setDocument(string $document): self
    {
        $this->document = $document;

        return $this;
    }

}