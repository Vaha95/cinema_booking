<?php

namespace App\Domain\Booking\Entity\TransferObject;

use App\Domain\Booking\Exception\NotPositiveRealNumberException;
use App\Domain\Booking\Assertion\PositiveRealNumberAssertion;
use Symfony\Component\Uid\Uuid;

class CinemaHallDTO
{
    public Uuid $id;

    /**
     * @param int $hallCapacity
     *
     * @throws NotPositiveRealNumberException
     */
    public function __construct(public readonly int $hallCapacity)
    {
        PositiveRealNumberAssertion::validate($hallCapacity);

        $this->id = Uuid::v4();
    }
}