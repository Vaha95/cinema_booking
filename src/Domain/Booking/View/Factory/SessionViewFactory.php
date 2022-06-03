<?php

namespace App\Domain\Booking\View\Factory;

use App\Domain\Booking\Exception\NotPositiveRealNumberException;
use App\Domain\Booking\View\SessionView;

class SessionViewFactory
{
    /**
     * @return SessionView[]
     *
     * @throws \Exception
     * @throws NotPositiveRealNumberException
     */
    public function createByCollection(array $sessions): array
    {
        return array_map(fn($session) => new SessionView($session), $sessions);
    }
}