<?php

namespace App\Domain\Booking\Entity\Factory;

use App\Domain\Booking\Entity\ValueObject\Customer;

class CustomerFactory
{
    public static function create(string $name, int $duration): Customer
    {
        return new Customer($name, $duration);
    }
}