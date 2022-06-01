<?php

namespace App\Domain\Booking\Entity\Factory;

use App\Domain\Booking\Entity\CinemaHall;
use App\Domain\Booking\Entity\TransferObject\CinemaHallDTO;
use App\Domain\Booking\Exception\NotPositiveRealNumberException;

class CinemaHallFactory
{
    /**
     * @param int $hallCapacity
     *
     * @throws NotPositiveRealNumberException
     *
     * @return CinemaHall
     */
    static public function create(int $hallCapacity): CinemaHall
    {
        $cinemaHallDTO = new CinemaHallDTO($hallCapacity);

        return new CinemaHall($cinemaHallDTO);
    }
}