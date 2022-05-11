<?php

namespace App\Entity;

use App\Repository\VolRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=VolRepository::class)
 */
class Vol
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("vols")
     */
    private $id;

    /**
     * @Groups("vols")
     * @ORM\Column(type="date")
     */
    private $Datedepart;

    /**
     * @Groups("vols")
     * @ORM\Column(type="date")
     */
    private $Datearrive;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     * min=3,max=15,
     * minMessage ="Le nom du vol doit contenir au moins 3 caractere",
     * maxMessage ="Le nom du vol doit contenir 15 caractere Maximum")
     * @ORM\Column(type="string", length=30)
     * @Groups("vols")
     */
    private $nom;

    /**
     * @Groups("vols")
     * @ORM\Column(type="time")
     */
    private $heuredepart;

    /**
     * @Groups("vols")
     * @ORM\Column(type="time")
     */
    private $heurearrive;

    /**
     * @Groups("vols")
     * @Assert\NotBlank
     * @Assert\Length(
     * min=3,max=15,
     * minMessage ="La destination du vol doit contenir au moins 3 caractere",
     * maxMessage ="La destination du vol doit contenir 15 caractere Maximum")
     * @ORM\Column(type="string", length=30)
     */
    private $destination;

    /**
     * @Groups("vols")
     * @Assert\Positive
     * @ORM\Column(type="integer")
     */
    private $nbrplace;



    /**
     * @ORM\ManyToOne(targetEntity=Airline::class, inversedBy="vols")
     */
    private $airline;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatedepart(): ?\DateTimeInterface
    {
        return $this->Datedepart;
    }

    public function setDatedepart(\DateTimeInterface $Datedepart): self
    {
        $this->Datedepart = $Datedepart;

        return $this;
    }

    public function getDatearrive(): ?\DateTimeInterface
    {
        return $this->Datearrive;
    }

    public function setDatearrive(\DateTimeInterface $Datearrive): self
    {
        $this->Datearrive = $Datearrive;

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

    public function getHeuredepart(): ?\DateTimeInterface
    {
        return $this->heuredepart;
    }

    public function setHeuredepart(\DateTimeInterface $heuredepart): self
    {
        $this->heuredepart = $heuredepart;

        return $this;
    }

    public function getHeurearrive(): ?\DateTimeInterface
    {
        return $this->heurearrive;
    }

    public function setHeurearrive(\DateTimeInterface $heurearrive): self
    {
        $this->heurearrive = $heurearrive;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getNbrplace(): ?int
    {
        return $this->nbrplace;
    }

    public function setNbrplace(int $nbrplace): self
    {
        $this->nbrplace = $nbrplace;

        return $this;
    }


    public function getAirline(): ?Airline
    {
        return $this->airline;
    }

    public function setAirline(?Airline $airline): self
    {
        $this->airline = $airline;

        return $this;
    }

}
