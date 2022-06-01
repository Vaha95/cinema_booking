<?php

namespace App\Domain\Booking\Entity\Factory;

use App\Domain\Booking\Entity\Film;
use App\Domain\Booking\Entity\TransferObject\FilmDTO;
use App\Domain\Booking\Exception\NotPositiveRealNumberException;

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
        $filmDTO = new FilmDTO($name, $duration);

        return new Film($filmDTO);
    }
}