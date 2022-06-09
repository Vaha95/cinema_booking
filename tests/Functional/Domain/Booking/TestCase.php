<?php

namespace App\Tests\Functional\Domain\Booking;

use App\Domain\Booking\Command\BookingCommand;
use App\Domain\Booking\Entity\Session;
use App\Tests\Acceptance\Booking\Acceptance;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\TraceableMessageBus;

class TestCase extends KernelTestCase
{
    protected function getCommandBus(): TraceableMessageBus
    {
        return $this->getContainer()->get(MessageBusInterface::class);
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