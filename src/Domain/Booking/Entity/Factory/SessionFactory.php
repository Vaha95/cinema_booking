<?php

namespace App\Domain\Booking\Entity\Factory;

use App\Domain\Booking\Entity\CinemaHall;
use App\Domain\Booking\Entity\Film;
use App\Domain\Booking\Entity\Session;

class SessionFactory
{
    static public function create(Film $film, CinemaHall $cinemaHall, \DateTimeImmutable $startAt) {
        $sesssion = new Session();
        $sesssion->setFilm($film);
        $sesssion->setCinemaHall($cinemaHall);
        $sesssion->setStartAt($startAt);

        return $sesssion;
    }
}
