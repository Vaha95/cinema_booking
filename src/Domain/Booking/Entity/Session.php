<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToMany(mappedBy: 'session', targetEntity: Booking::class, orphanRemoval: true)]
    private $bookings;

    #[ORM\Column(type: 'datetime_immutable')]
    private $startAt;

    #[ORM\ManyToOne(targetEntity: CinemaHall::class, inversedBy: 'sessions')]
    #[ORM\JoinColumn(nullable: false)]
    private $cinemaHall;

    #[ORM\ManyToOne(targetEntity: Film::class, inversedBy: 'sessions')]
    #[ORM\JoinColumn(nullable: false)]
    private $film;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setSession($this);
        }

        return $this;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getCinemaHall(): CinemaHall
    {
        return $this->cinemaHall;
    }

    public function setCinemaHall(CinemaHall $cinemaHall): self
    {
        $this->cinemaHall = $cinemaHall;

        return $this;
    }

    public function getFilm(): Film
    {
        return $this->film;
    }

    public function setFilm(Film $film): self
    {
        $this->film = $film;

        return $this;
    }
}
