<?php

namespace App\Tests\Functional\Domain\Booking\Command\Handler;

use App\Domain\Booking\Command\BookingCommand;
use App\Domain\Booking\Entity\Booking;
use App\Tests\Functional\Domain\Booking\TestCase;

class BookingPlacesHandlerTest extends TestCase
{
    public function testHandleCommand(): void
    {
        $em = $this->getEntityManager();

        $bus = $this->getCommandBus();

        $command = new BookingCommand();
        $command->session = $session = $this->getSession($em);
        $command->name = $name = 'TestName';
        $command->phone = $phone = '9011111111';
        $command->places = $places = 7;

        $bus->dispatch($command);

        /** @var Booking[] $booking */
        $booking = $this->getEntityManager()?->getRepository(Booking::class)->findBy(['session' => $session->getId()]);

        $this->assertNotNull($booking);
        $this->assertCount(1, $booking);
        $this->assertEquals($name, $booking[0]->getCustomer()->name);
        $this->assertEquals($phone, $booking[0]->getCustomer()->phone);
        $this->assertEquals($places, $booking[0]->getCountOfSeats());
    }
}