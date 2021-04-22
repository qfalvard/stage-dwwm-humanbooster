<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObjectifRepository")
 */
class Objectif
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
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Module", inversedBy="objectif")
     */
    private $module;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ordreAffichage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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
    public function getOrdreAffichage(): ?string
    {
        return $this->ordreAffichage;
    }

    public function setOrdreAffichage(string $ordreAffichage)
    {
        $this->ordreAffichage = $ordreAffichage;

        return $this;
    }
}
