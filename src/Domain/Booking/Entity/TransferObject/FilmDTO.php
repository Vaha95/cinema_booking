<?php

namespace App\Domain\Booking\Entity\TransferObject;

use App\Domain\Booking\Exception\NotPositiveRealNumberException;
use App\Domain\Booking\Assertion\PositiveRealNumberAssertion;
use Symfony\Component\Uid\Uuid;

class FilmDTO
{
    public Uuid $id;

    /**
     * @throws NotPositiveRealNumberException
     */
    public function __construct(public readonly string $name, public readonly int $duration)
    {
        PositiveRealNumberAssertion::validate($duration);

        $this->id = Uuid::v4();
    }
}