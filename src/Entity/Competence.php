<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetenceRepository")
 */
class Competence
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
     * @ORM\ManyToOne(targetEntity="App\Entity\CCP", inversedBy="competence")
     */
    private $ccp;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Module", mappedBy="competence")
     */
    private $module;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ordreAffichage;

    public function __construct()
    {
        $this->module = new ArrayCollection();
    }

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

    public function getCcp(): ?CCP
    {
        return $this->ccp;
    }

    public function setCcp(?CCP $ccp): self
    {
        $this->ccp = $ccp;

        return $this;
    }

    /**
     * @return Collection|Module[]
     */
    public function getModule(): Collection
    {
        return $this->module;
    }

    public function addModule(Module $module): self
    {
        if (!$this->module->contains($module)) {
            $this->module[] = $module;
            $module->setCompetence($this);
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        if ($this->module->contains($module)) {
            $this->module->removeElement($module);
            // set the owning side to null (unless already changed)
            if ($module->getCompetence() === $this) {
                $module->setCompetence(null);
            }
        }

        return $this;
    }
    public function getOrdreAffichage(): ?string
    {
        return $this->ordreAffichage;
    }

    public function setOrdreAffichage(string $ordreAffichage): self
    {
        $this->ordreAffichage = $ordreAffichage;

        return $this;
    }
}
