<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
class Album
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column]
    private ?bool $Publie = null;

    #[ORM\ManyToOne(inversedBy: 'Albums')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Membre $Auteur = null;

    #[ORM\ManyToMany(targetEntity: Photo::class, inversedBy: 'Albums')]
    private Collection $Objets;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    public function __construct()
    {
        $this->Objets = new ArrayCollection();
    }

    public function __toString()
    {
        $s = '';
        $s .= $this->getId() .' '. $this->getNom() .' ';
        return $s;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function isPublie(): ?bool
    {
        return $this->Publie;
    }

    public function setPublie(bool $Publie): static
    {
        $this->Publie = $Publie;

        return $this;
    }

    public function getAuteur(): ?Membre
    {
        return $this->Auteur;
    }

    public function setAuteur(?Membre $Auteur): static
    {
        $this->Auteur = $Auteur;

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getObjets(): Collection
    {
        return $this->Objets;
    }

    public function addObjet(Photo $objet): static
    {
        if (!$this->Objets->contains($objet)) {
            $this->Objets->add($objet);
        }

        return $this;
    }

    public function removeObjet(Photo $objet): static
    {
        $this->Objets->removeElement($objet);

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
