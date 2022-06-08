<?php

namespace App\Tests\Functional\Domain\Booking\Command;

use App\Domain\Booking\Entity\Booking;
use App\Tests\Functional\Domain\Booking\TestCase;

class BookingPlacesHandlerTest extends TestCase
{
    public function testHandleCommand(): void
    {
        $em = $this->getEntityManager();

        $session = $this->getSession($em);
        $name = 'TestName';
        $phone = '9011111111';
        $places = 7;

        $this->sendCommand($session, $name, $phone, $places, $em);

        /** @var Booking[] $booking */
        $booking = $this->getEntityManager()?->getRepository(Booking::class)->findBy(['session' => $session->getId()]);

        $this->assertNotNull($booking);
        $this->assertCount(1, $booking);
        $this->assertEquals($name, $booking[0]->getCustomer()->name);
        $this->assertEquals($phone, $booking[0]->getCustomer()->phone);
        $this->assertEquals($places, $booking[0]->getCountOfSeats());
    }
}