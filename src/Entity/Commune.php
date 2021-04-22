<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommuneRepository")
 */
class Commune
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Adresse", mappedBy="commune")
     */
    private $adresses;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\CodePostal", inversedBy="communes")
     */
    private $codePostaux;

    public function __construct()
    {
        $this->adresses = new ArrayCollection();
        $this->codePostaux = new ArrayCollection();
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

    /**
     * @return Collection|Adresse[]
     */
    public function getAdresses(): Collection
    {
        return $this->adresses;
    }

    public function addAdress(Adresse $adress): self
    {
        if (!$this->adresses->contains($adress)) {
            $this->adresses[] = $adress;
            $adress->setCommune($this);
        }

        return $this;
    }

    public function removeAdress(Adresse $adress): self
    {
        if ($this->adresses->contains($adress)) {
            $this->adresses->removeElement($adress);
            // set the owning side to null (unless already changed)
            if ($adress->getCommune() === $this) {
                $adress->setCommune(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CodePostal[]
     */
    public function getCodePostaux(): Collection
    {
        return $this->codePostaux;
    }

    public function addCodePostaux(CodePostal $codePostaux): self
    {
        if (!$this->codePostaux->contains($codePostaux)) {
            $this->codePostaux[] = $codePostaux;
        }

        return $this;
    }

    public function removeCodePostaux(CodePostal $codePostaux): self
    {
        if ($this->codePostaux->contains($codePostaux)) {
            $this->codePostaux->removeElement($codePostaux);
        }

        return $this;
    }
}
