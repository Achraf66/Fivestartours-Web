<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\Column(type="date")
     */
    private $checkin;

    /**
     * @ORM\Column(type="date")
     */
    private $checkout;



    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *     min = 3,
     *     max = 15,
     *     minMessage ="La destination doit contenir 5 caractere minimum",
     *     maxMessage ="La destination doit contenir 15 caractere Maximum")
     * @ORM\Column(type="string", length=30)
     */
    private $endroit;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *     min = 3,
     *     max = 15,
     *     minMessage ="La destination doit contenir 5 caractere minimum",
     *     maxMessage ="La destination doit contenir 15 caractere Maximum")
     * @ORM\Column(type="string", length=30)
     */
    private $nomhotel;

    /**
     * @ORM\Column(type="date")
     */
    private $datereservation;

    /**
     * @ORM\ManyToOne(targetEntity=Hotel::class, inversedBy="reservations")
     */
    private $hotel;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCheckin(): ?\DateTimeInterface
    {
        return $this->checkin;
    }

    public function setCheckin(\DateTimeInterface $checkin): self
    {

        $this->checkin = $checkin;

        return $this;
    }

    public function getCheckout(): ?\DateTimeInterface
    {
        return $this->checkout;
    }

    public function setCheckout(\DateTimeInterface $checkout): self
    {

        $this->checkout = $checkout;

        return $this;
    }



    public function getEndroit(): ?string
    {
        return $this->endroit;
    }

    public function setEndroit(string $endroit): self
    {
        $this->endroit = $endroit;

        return $this;
    }

    public function getNomhotel(): ?string
    {
        return $this->nomhotel;
    }

    public function setNomhotel(string $nomhotel): self
    {
        $this->nomhotel = $nomhotel;

        return $this;
    }

    public function getDatereservation(): ?\DateTimeInterface
    {
        return $this->datereservation;
    }

    public function setDatereservation(\DateTimeInterface $datereservation): self
    {

        $this->datereservation = $datereservation;

        return $this;
    }

    public function getReservation(): ?Hotel
    {
        return $this->reservation;
    }

    public function setReservation(?Hotel $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }

    public function getHotel(): ?hotel
    {
        return $this->hotel;
    }

    public function setHotel(?hotel $hotel): self
    {
        $this->hotel = $hotel;

        return $this;
    }
}
