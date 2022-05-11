<?php

namespace App\Entity;

use App\Repository\AirlineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ORM\Entity(repositoryClass=AirlineRepository::class)
 */
class Airline
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("airline")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     * min=3,max=15,
     * minMessage ="Nom airline doit contenir au moins 3 caractere",
     * maxMessage ="Nom airline doit contenir 15 caractere Maximum")
     * @ORM\Column(type="string", length=30)
     * @Groups("airline")
     */
    private $nomairline;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     * min=3,max=15,
     * minMessage ="Le Pays doit contenir au moins 3 caractere",
     * maxMessage ="Le Pays doit contenir 15 caractere Maximum")
     * @ORM\Column(type="string", length=30)
     * @Groups("airline")
     */
    private $pays;

    /**
     * @Assert\Positive
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("airline")
     */
    private $stars;

    /**
     * @ORM\OneToMany(targetEntity=Vol::class, mappedBy="airline")
     */
    private $vols;

    public function __construct()
    {
        $this->vols = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomairline(): ?string
    {
        return $this->nomairline;
    }

    public function setNomairline(string $nomairline): self
    {
        $this->nomairline = $nomairline;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getStars(): ?int
    {
        return $this->stars;
    }

    public function setStars(?int $stars): self
    {
        $this->stars = $stars;

        return $this;
    }

    /**
     * @return Collection<int, Vol>
     */
    public function getVols(): Collection
    {
        return $this->vols;
    }

    public function addVol(Vol $vol): self
    {
        if (!$this->vols->contains($vol)) {
            $this->vols[] = $vol;
            $vol->setAirline($this);
        }

        return $this;
    }

    public function removeVol(Vol $vol): self
    {
        if ($this->vols->removeElement($vol)) {
            // set the owning side to null (unless already changed)
            if ($vol->getAirline() === $this) {
                $vol->setAirline(null);
            }
        }

        return $this;
    }
}
