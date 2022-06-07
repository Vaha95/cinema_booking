<?php

namespace App\Tests\Functional\Booking\Command;

use App\Domain\Booking\Command\BookingCommand;
use App\Domain\Booking\Command\Handler\BookingCommandHandler;
use App\Domain\Booking\Entity\Booking;
use App\Domain\Booking\Entity\Session;
use App\Domain\Booking\Exception\NotPositiveRealNumberException;
use App\Factory\FlockFactory;
use App\Tests\Acceptance\Booking\Acceptance;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use TypeError;

class BookPlacesTest extends TestCase
{
    private EntityManagerInterface $em;

    protected function setUp(): void
    {
        parent::setUp();

        $this->em = $this->getEntityManager();
    }

    public function testHandleCommand(): void
    {
        $session = $this->getSession();
        $name = 'TestName';
        $phone = '9011111111';
        $places = 7;

        $this->sendCommand($this->getSession(), $name, $phone, $places);

        /** @var Booking[] $booking */
        $booking = $this->em->getRepository(Booking::class)->findBy(['session' => $session->getId()]);

        $this->assertNotNull($booking);
        $this->assertCount(1, $booking);
        $this->assertEquals($name, $booking[0]->getCustomer()->name);
        $this->assertEquals($phone, $booking[0]->getCustomer()->phone);
        $this->assertEquals($places, $booking[0]->getCountOfSeats());
    }

    /**
     * @dataProvider handleCommandFailDataProvider
     */
    public function testHandleCommandFail(array $arguments, string $exception): void
    {
        $this->expectException($exception);

        $this->sendCommand(...$arguments);
    }

    public function handleCommandFailDataProvider(): \Generator
    {
        $session = $this->getSession();

        yield [
            'arguments' => [$session, 'TestName', null, 1],
            'exception' => TypeError::class,
        ];
        yield [
            'arguments' => [$session, null, '9017007080', 1],
            'exception' => TypeError::class,
        ];
        yield [
            'arguments' => [null, 'TestName', '9017007080', 1],
            'exception' => TypeError::class,
        ];
        yield [
            'arguments' => [$session, 'TestName', '9017007080', -1],
            'exception' => NotPositiveRealNumberException::class,
        ];
    }

    private function sendCommand(Session $session, string $name, string $phone, int $places): void
    {
        $command = new BookingCommand();
        $command->session = $session;
        $command->name = $name;
        $command->phone = $phone;
        $command->places = $places;

        $handler = $this->getHandler();
        $handler->__invoke($command);
    }

    private function getHandler(): BookingCommandHandler
    {
        return new BookingCommandHandler(new FlockFactory(), $this->em);
    }

    private function getSession(): Session
    {
        $em = $this->em ?? $this->getEntityManager();

        $sessions = $em->getRepository(Session::class)->findAll();
        return $sessions[0];
    }

    private function getEntityManager(): EntityManager
    {
        $client = Acceptance::getClient();
        return $client->getContainer()->get('doctrine.orm.entity_manager');
    }
}
