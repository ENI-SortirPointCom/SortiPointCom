<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EtatRepository")
 */
class Etat
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
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sortie", mappedBy="etat", orphanRemoval=true)
     */
    private $etat;

    public function __construct()
    {
        $this->etat = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Sortie[]
     */
    public function getEtat(): Collection
    {
        return $this->etat;
    }

    public function addEtat(Sortie $etat): self
    {
        if (!$this->etat->contains($etat)) {
            $this->etat[] = $etat;
            $etat->setEtat($this);
        }

        return $this;
    }

    public function removeEtat(Sortie $etat): self
    {
        if ($this->etat->contains($etat)) {
            $this->etat->removeElement($etat);
            // set the owning side to null (unless already changed)
            if ($etat->getEtat() === $this) {
                $etat->setEtat(null);
            }
        }

        return $this;
    }
}
