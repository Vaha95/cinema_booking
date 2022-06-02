<?php

namespace App\Domain\Booking\Entity\Factory;

use App\Domain\Booking\Entity\CinemaHall;
use App\Domain\Booking\Exception\NotPositiveRealNumberException;
use Symfony\Component\Uid\Uuid;

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
        return new CinemaHall(Uuid::v4(), $hallCapacity);
    }
}