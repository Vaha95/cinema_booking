<?php

namespace App\Tests\Functional\Domain\Booking;

use App\Domain\Booking\Command\BookingCommand;
use App\Domain\Booking\Entity\Session;
use App\Tests\Acceptance\Domain\Booking\Acceptance;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\MessageBusInterface;

class TestCase extends KernelTestCase
{
    protected function sendCommand($session, $name, $phone, $places, EntityManager $em): void
    {
        $bus = $this->getContainer()->get(MessageBusInterface::class);

        $command = new BookingCommand();
        $command->session = $session;
        $command->name = $name;
        $command->phone = $phone;
        $command->places = $places;

        $bus->dispatch($command);
    }

    protected function getSession(EntityManager $em): Session
    {
        $sessions = $em->getRepository(Session::class)->findAll();
        return $sessions[0];
    }

    protected function getEntityManager(): EntityManager
    {
        $client = Acceptance::getClient();
        return $client->getContainer()->get('doctrine.orm.entity_manager');
    }
}