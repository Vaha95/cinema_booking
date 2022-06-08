<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Entity\Factory\BookingFactory;
use App\Domain\Booking\Entity\Factory\CustomerFactory;
use App\Domain\Booking\Exception\InsufficientlyFreePlacesException;
use App\Domain\Booking\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    private Uuid $id;

    #[ORM\OneToMany(mappedBy: 'session', targetEntity: Booking::class, cascade: ["persist"], orphanRemoval: true)]
    private Collection $bookings;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $startAt;

    #[ORM\ManyToOne(targetEntity: CinemaHall::class, inversedBy: 'sessions')]
    #[ORM\JoinColumn(nullable: false)]
    private CinemaHall $cinemaHall;

    #[ORM\ManyToOne(targetEntity: Film::class, inversedBy: 'sessions')]
    #[ORM\JoinColumn(nullable: false)]
    private Film $film;

    public function __construct(Uuid $id, Film $film, CinemaHall $cinemaHall, \DateTimeImmutable $startAt)
    {
        $this->id = $id;
        $this->film = $film;
        $this->startAt = $startAt;
        $this->cinemaHall = $cinemaHall;
        $this->bookings = new ArrayCollection();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function getCinemaHall(): CinemaHall
    {
        return $this->cinemaHall;
    }

    public function getFilm(): Film
    {
        return $this->film;
    }

    public function getFreePlaces(): int
    {
        $occupiedPlaces = 0;

        foreach ($this->bookings as $booking) {
            /* @var Booking $booking */
            $occupiedPlaces += $booking->getCountOfSeats();
        }

        return $this->cinemaHall->getHallCapacity() - $occupiedPlaces;
    }

    public function assertCanBookOrder(int $countOfSeats): bool
    {
        return $this->getFreePlaces() >= $countOfSeats;
    }

    public function bookingOrder(int $countOfSeats, string $name, string $phone): void
    {
        $customer = CustomerFactory::create($name, $phone);
        $this->bookings->add(BookingFactory::create($countOfSeats, $customer, $this));
    }
}
