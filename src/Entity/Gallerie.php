<?php

namespace App\Entity;

use App\Repository\GallerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GallerieRepository::class)]
class Gallerie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Auteur = null;

    #[ORM\OneToMany(mappedBy: 'gallerie', targetEntity: Photo::class)]
    private Collection $Photo;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    public function __toString()
    {
        $s = '';
        $s .= $this->getId() .' '. $this->getNom() .' ';
        return $s;
    }

    public function __construct()
    {
        $this->tag = new ArrayCollection();
        $this->Photo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuteur(): ?string
    {
        return $this->Auteur;
    }

    public function setAuteur(string $Auteur): static
    {
        $this->Auteur = $Auteur;

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhoto(): Collection
    {
        return $this->Photo;
    }

    public function addPhoto(Photo $photo): static
    {
        if (!$this->Photo->contains($photo)) {
            $this->Photo->add($photo);
            $photo->setGallerie($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): static
    {
        if ($this->Photo->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getGallerie() === $this) {
                $photo->setGallerie(null);
            }
        }

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }


}
