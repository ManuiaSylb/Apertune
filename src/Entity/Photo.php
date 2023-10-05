<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Titre = null;

    #[ORM\Column(length: 255)]
    private ?string $Auteur = null;

    #[ORM\ManyToOne(inversedBy: 'Photo')]
    private ?Gallerie $gallerie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(nullable: true)]
    private ?string $Ouverture = null;

    #[ORM\Column(nullable: true)]
    private ?int $ISO = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ShutterSpeed = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): static
    {
        $this->Titre = $Titre;

        return $this;
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

    public function getGallerie(): ?Gallerie
    {
        return $this->gallerie;
    }

    public function setGallerie(?Gallerie $gallerie): static
    {
        $this->gallerie = $gallerie;

        return $this;
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

    public function getOuverture(): ?string
    {
        return $this->Ouverture;
    }

    public function setOuverture(?string $Ouverture): static
    {
        $this->Ouverture = $Ouverture;

        return $this;
    }

    public function getISO(): ?int
    {
        return $this->ISO;
    }

    public function setISO(?int $ISO): static
    {
        $this->ISO = $ISO;

        return $this;
    }

    public function getShutterSpeed(): ?string
    {
        return $this->ShutterSpeed;
    }

    public function setShutterSpeed(?string $ShutterSpeed): static
    {
        $this->ShutterSpeed = $ShutterSpeed;

        return $this;
    }



}
