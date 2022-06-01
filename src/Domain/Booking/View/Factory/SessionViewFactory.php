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
    public function createByCollection(iterable $sessions): array
    {
        $sessionViews = [];

        foreach ($sessions as $session) {
            $sessionViews[] = new SessionView(
                $session['name'],
                $session['freePlaces'],
                $session['startAt'],
                $session['duration']
            );
        }

        return $sessionViews;
    }
}