<?php

namespace App\Domain\Booking\Entity\Factory;

use App\Domain\Booking\Entity\Booking;
use App\Domain\Booking\Entity\Session;
use App\Domain\Booking\Entity\ValueObject\Customer;
use Symfony\Component\Uid\Uuid;

class BookingFactory
{
    static public function create(int $countOfSeats, Customer $customer, Session $session): Booking
    {
        return new Booking(Uuid::v4(), $countOfSeats, $customer, $session);
    }
}
