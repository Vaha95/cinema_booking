<?php

namespace App\Domain\Booking\Entity\Factory;

use App\Domain\Booking\Entity\Film;
use App\Domain\Booking\Exception\NotPositiveRealNumberException;
use Symfony\Component\Uid\Uuid;

class FilmFactory
{
    /**
     * @param string $name
     * @param int $duration
     *
     * @throws NotPositiveRealNumberException
     *
     * @return Film
     */
    static public function create(string $name, int $duration): Film
    {
        return new Film(Uuid::v4(), $name, $duration);
    }
}