<?php

namespace App\Domain\Booking\Entity\Factory;

use App\Domain\Booking\Entity\CinemaHall;
use App\Domain\Booking\Entity\Film;
use App\Domain\Booking\Entity\Session;
use App\Domain\Booking\Entity\TransferObject\SessionDTO;

class SessionFactory
{
    static public function create(Film $film, CinemaHall $cinemaHall, \DateTimeImmutable $startAt): Session
    {
        $sesssionDTO = new SessionDTO($film, $cinemaHall, $startAt);
        $sesssion = new Session($sesssionDTO);

        return $sesssion;
    }
}
