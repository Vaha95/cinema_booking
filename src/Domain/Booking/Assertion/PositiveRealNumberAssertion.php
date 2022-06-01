<?php

namespace App\Domain\Booking\Assertion;

use App\Domain\Booking\Exception\NotPositiveRealNumberException;

class PositiveRealNumberAssertion
{
    public static function validate(int $value): void
    {
        if (!($value > 0)) {
            throw new NotPositiveRealNumberException(sprintf('%d is not positive real number!', $value));
        }
    }
}