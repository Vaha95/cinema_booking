<?php

namespace App\Domain\Booking\Entity\TransferObject;

use App\Domain\Booking\Exception\NotPositiveRealNumberException;
use App\Domain\Booking\Validator\PositiveRealNumberValidator;

class FilmDTO
{
    public string $name;
    public int $duration;

    /**
     * @param string $name
     * @param int $duration
     *
     * @throws NotPositiveRealNumberException
     */
    public function __construct(string $name, int $duration)
    {
        PositiveRealNumberValidator::validate($duration);

        $this->name = $name;
        $this->duration = $duration;
    }


}