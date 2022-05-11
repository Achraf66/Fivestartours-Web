<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Reservation;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=HotelRepository::class)
 */
class Hotel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *     min = 5,
     *     max = 15,
     *     minMessage ="Le nom de l'hotel  doit etre compose de 3 caractere minimum",
     *     maxMessage ="Le nom de l'hotel doit etre compose 15 caractere Maximum")
     * @ORM\Column(type="string", length=30)
     */
    private $nom;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *     min = 5,
     *     max = 15,
     *     minMessage ="Le pays de hotel doit etre compose de 3 caractere minimum",
     *     maxMessage ="Le pays de hotel doit etre compose 15 caractere Maximum")
     * @ORM\Column(type="string", length=30)
     */
    private $pays;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="Hotel")
     */
    private $reservations;



    public function __construct()
    {
        $this->reservation = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }





    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * @param mixed $pays
     */
    public function setPays($pays): void
    {
        $this->pays = $pays;
    }

    /**
     * @return Collection<int, reservation>
     */
    public function getReservation(): Collection
    {
        return $this->reservation;
    }

    public function addReservation(reservation $reservation): self
    {
        if (!$this->reservation->contains($reservation)) {
            $this->reservation[] = $reservation;
            $reservation->setReservation($this);
        }

        return $this;
    }

    public function removeReservation(reservation $reservation): self
    {
        if ($this->reservation->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getReservation() === $this) {
                $reservation->setReservation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

}
