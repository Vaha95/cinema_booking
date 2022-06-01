<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Entity\TransferObject\SessionDTO;
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

    #[ORM\OneToMany(mappedBy: 'session', targetEntity: Booking::class, orphanRemoval: true)]
    private Collection $bookings;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $startAt;

    #[ORM\ManyToOne(targetEntity: CinemaHall::class, inversedBy: 'sessions')]
    #[ORM\JoinColumn(nullable: false)]
    private CinemaHall $cinemaHall;

    #[ORM\ManyToOne(targetEntity: Film::class, inversedBy: 'sessions')]
    #[ORM\JoinColumn(nullable: false)]
    private Film $film;

    public function __construct(SessionDTO $sessionDTO)
    {
        $this->bookings = new ArrayCollection();
        $this->setId($sessionDTO->id);
        $this->setFilm($sessionDTO->film);
        $this->setCinemaHall($sessionDTO->cinemaHall);
        $this->setStartAt($sessionDTO->startAt);
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

    private function getFilm(): Film
    {
        return $this->film;
    }

    private function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    private function setStartAt(\DateTimeImmutable $startAt): void
    {
        $this->startAt = $startAt;
    }

    private function setCinemaHall(CinemaHall $cinemaHall): void
    {
        $this->cinemaHall = $cinemaHall;
    }

    private function setFilm(Film $film): void
    {
        $this->film = $film;
    }
}
