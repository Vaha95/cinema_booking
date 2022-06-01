<?php

namespace App\Domain\Booking\Entity\TransferObject;

use App\Domain\Booking\Exception\NotPositiveRealNumberException;
use App\Domain\Booking\Validator\PositiveRealNumberValidator;

class CinemaHallDTO
{
    public int $hallCapacity;

    /**
     * @param int $hallCapacity
     *
     * @throws NotPositiveRealNumberException
     */
    public function __construct(int $hallCapacity)
    {
        PositiveRealNumberValidator::validate($hallCapacity);

        $this->hallCapacity = $hallCapacity;
    }
}