<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TitreProfessionnelRepository")
 */
class TitreProfessionnel
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
    private $sigle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateApplication;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CCP", mappedBy="titreProfessionnel")
     */
    private $ccp;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Session", mappedBy="titreProfessionnel")
     */
    private $sessions;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActif;

    public function __construct()
    {
        $this->setIsActif(1);
        $this->ccp = new ArrayCollection();
        $this->sessions = new ArrayCollection();
        $this->dateApplication = new \DateTime('2020-01-01');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSigle(): ?string
    {
        return $this->sigle;
    }

    public function setSigle(string $sigle): self
    {
        $this->sigle = $sigle;

        return $this;
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

    public function getDateApplication(): ?\DateTimeInterface
    {
        return $this->dateApplication;
    }

    public function setDateApplication(\DateTimeInterface $dateApplication): self
    {
        $this->dateApplication = $dateApplication;

        return $this;
    }

    /**
     * @return Collection|CCP[]
     */
    public function getCcp(): Collection
    {
        return $this->ccp;
    }

    public function addCcp(CCP $ccp): self
    {
        if (!$this->ccp->contains($ccp)) {
            $this->ccp[] = $ccp;
            $ccp->setTitreProfessionnel($this);
        }

        return $this;
    }

    public function removeCcp(CCP $ccp): self
    {
        if ($this->ccp->contains($ccp)) {
            $this->ccp->removeElement($ccp);
            // set the owning side to null (unless already changed)
            if ($ccp->getTitreProfessionnel() === $this) {
                $ccp->setTitreProfessionnel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Session[]
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setTitreProfessionnel($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->contains($session)) {
            $this->sessions->removeElement($session);
            // set the owning side to null (unless already changed)
            if ($session->getTitreProfessionnel() === $this) {
                $session->setTitreProfessionnel(null);
            }
        }

        return $this;
    }

    public function getIsActif(): ?bool
    {
        return $this->isActif;
    }

    public function setIsActif(bool $isActif): self
    {
        $this->isActif = $isActif;

        return $this;
    }
}
