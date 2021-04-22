<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ModuleRepository")
 */
class Module
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
     * @ORM\Column(type="boolean")
     */
    private $isTre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Competence", inversedBy="module")
     */
    private $competence;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Objectif", mappedBy="module")
     */
    private $objectif;

    /**
     * @ORM\Column(type="boolean")
     */
    private $examen;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Former", mappedBy="module")
     */
    private $formers;

       /**
     * @ORM\Column(type="string", length=255)
     */
    private $ordreAffichage;
    
    public function __construct()
    {
        $this->objectif = new ArrayCollection();
        $this->formers = new ArrayCollection();
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

    public function getIsTre(): ?bool
    {
        return $this->isTre;
    }

    public function setIsTre(bool $isTre): self
    {
        $this->isTre = $isTre;

        return $this;
    }
    public function getExamen(): ?bool
    {
        return $this->examen;
    }

    public function setExamen(bool $examen): self
    {
        $this->examen = $examen;

        return $this;
    }
    public function getCompetence(): ?Competence
    {
        return $this->competence;
    }

    public function setCompetence(?Competence $competence): self
    {
        $this->competence = $competence;

        return $this;
    }

    /**
     * @return Collection|Objectif[]
     */
    public function getObjectif(): Collection
    {
        return $this->objectif;
    }

    public function addObjectif(Objectif $objectif): self
    {
        if (!$this->objectif->contains($objectif)) {
            $this->objectif[] = $objectif;
            $objectif->setModule($this);
        }

        return $this;
    }

    public function removeObjectif(Objectif $objectif): self
    {
        if ($this->objectif->contains($objectif)) {
            $this->objectif->removeElement($objectif);
            // set the owning side to null (unless already changed)
            if ($objectif->getModule() === $this) {
                $objectif->setModule(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Former[]
     */
    public function getFormers(): Collection
    {
        return $this->formers;
    }

    public function addFormer(Former $former): self
    {
        if (!$this->formers->contains($former)) {
            $this->formers[] = $former;
            $former->setModule($this);
        }

        return $this;
    }

    public function removeFormer(Former $former): self
    {
        if ($this->formers->contains($former)) {
            $this->formers->removeElement($former);
            // set the owning side to null (unless already changed)
            if ($former->getModule() === $this) {
                $former->setModule(null);
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
