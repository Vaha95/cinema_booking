<?php

namespace App\Domain\Booking\Entity\Factory;

use App\Domain\Booking\Entity\CinemaHall;
use App\Domain\Booking\Entity\Film;
use App\Domain\Booking\Entity\Session;
use Symfony\Component\Uid\Uuid;

class SessionFactory
{
    static public function create(Film $film, CinemaHall $cinemaHall, \DateTimeImmutable $startAt): Session
    {
        return new Session(Uuid::v4(), $film, $cinemaHall, $startAt);
    }
}
