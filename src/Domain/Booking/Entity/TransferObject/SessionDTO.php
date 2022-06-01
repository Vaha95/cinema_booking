<?php

namespace App\Domain\Booking\Entity\TransferObject;

use App\Domain\Booking\Entity\CinemaHall;
use App\Domain\Booking\Entity\Film;
use App\Domain\Booking\Exception\NotPositiveRealNumberException;
use Symfony\Component\Uid\Uuid;

class SessionDTO
{
    public Uuid $id;

    /**
     * @throws NotPositiveRealNumberException
     */
    public function __construct(
        public readonly Film $film,
        public readonly CinemaHall $cinemaHall,
        public readonly \DateTimeImmutable $startAt
    ) {
        $this->id = Uuid::v4();
    }
}