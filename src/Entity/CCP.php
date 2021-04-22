<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CCPRepository")
 */
class CCP
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
    private $isTranverse;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TitreProfessionnel", inversedBy="ccp")
     */
    private $titreProfessionnel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Competence", mappedBy="ccp")
     */
    private $competence;
    /**
     * @ORM\Column(type="integer")
     */
    private $ordreAffichage;

    public function __construct()
    {
        $this->competence = new ArrayCollection();
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
    public function getOrdreAffichage(): ?int
    {
        return $this->ordreAffichage;
    }

    public function setOrdreAffichage(int $ordreAffichage): self
    {
        $this->ordreAffichage = $ordreAffichage;

        return $this;
    }

    public function getIsTranverse(): ?bool
    {
        return $this->isTranverse;
    }

    public function setIsTranverse(bool $isTranverse): self
    {
        $this->isTranverse = $isTranverse;

        return $this;
    }

    public function getTitreProfessionnel(): ?TitreProfessionnel
    {
        return $this->titreProfessionnel;
    }

    public function setTitreProfessionnel(?TitreProfessionnel $titreProfessionnel): self
    {
        $this->titreProfessionnel = $titreProfessionnel;

        return $this;
    }

    /**
     * @return Collection|Competence[]
     */
    public function getCompetence(): Collection
    {
        return $this->competence;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competence->contains($competence)) {
            $this->competence[] = $competence;
            $competence->setCcp($this);
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        if ($this->competence->contains($competence)) {
            $this->competence->removeElement($competence);
            // set the owning side to null (unless already changed)
            if ($competence->getCcp() === $this) {
                $competence->setCcp(null);
            }
        }

        return $this;
    }
}
