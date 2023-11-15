<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembreRepository::class)]
class Membre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Pseudo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Pays = null;


    #[ORM\Column]
    private ?int $Annee = null;

    #[ORM\OneToMany(mappedBy: 'Auteur', targetEntity: Album::class)]
    private Collection $Albums;

    #[ORM\OneToMany(mappedBy: 'Auteur', targetEntity: Photo::class)]
    private Collection $Photos;

    #[ORM\OneToOne(mappedBy: 'Auteur', cascade: ['persist', 'remove'])]
    private ?Gallerie $Gallerie = null;

    #[ORM\OneToOne(inversedBy: 'membre', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    public function __construct()
    {
        $this->Albums = new ArrayCollection();
        $this->Photos = new ArrayCollection();
    }

    public function __toString()
    {
        $s = '';
        $s .= $this->getPseudo();
        return $s;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->Pseudo;
    }

    public function setPseudo(string $Pseudo): static
    {
        $this->Pseudo = $Pseudo;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->Pays;
    }

    public function setPays(?string $Pays): static
    {
        $this->Pays = $Pays;

        return $this;
    }



    public function getAnnee(): ?int
    {
        return $this->Annee;
    }

    public function setAnnee(int $Annee): static
    {
        $this->Annee = $Annee;

        return $this;
    }

    /**
     * @return Collection<int, Album>
     */
    public function getAlbums(): Collection
    {
        return $this->Albums;
    }

    public function addAlbum(Album $album): static
    {
        if (!$this->Albums->contains($album)) {
            $this->Albums->add($album);
            $album->setAuteur($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): static
    {
        if ($this->Albums->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getAuteur() === $this) {
                $album->setAuteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->Photos;
    }

    public function addPhoto(Photo $photo): static
    {
        if (!$this->Photos->contains($photo)) {
            $this->Photos->add($photo);
            $photo->setAuteur($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): static
    {
        if ($this->Photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getAuteur() === $this) {
                $photo->setAuteur(null);
            }
        }

        return $this;
    }

    public function getGallerie(): ?Gallerie
    {
        return $this->Gallerie;
    }

    public function setGallerie(Gallerie $Gallerie): static
    {
        // set the owning side of the relation if necessary
        if ($Gallerie->getAuteur() !== $this) {
            $Gallerie->setAuteur($this);
        }

        $this->Gallerie = $Gallerie;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(User $User): static
    {
        $this->User = $User;

        return $this;
    }
}
