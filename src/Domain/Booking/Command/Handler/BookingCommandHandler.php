<?php

namespace App\Domain\Booking\Command\Handler;

use App\Domain\Booking\Command\BookingCommand;
use App\Domain\Booking\Exception\BookingNotAvailableException;
use App\Factory\FlockFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Lock\SharedLockInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class BookingCommandHandler
{
    private int $waitingCount = 0;
    private int $waitingLimit = 5;
    private int $waitingInterval = 1;

    public function __construct(private FlockFactory $flockFactory, private EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(BookingCommand $command): void
    {
        $lock = $this->flockFactory::create()->createLock('booking');

        if (!$lock->acquire() && !$this->checkLockAvailability($lock)) {
            throw new BookingNotAvailableException();
        }

        $command->session->bookingOrder(
            $command->places,
            $command->name,
            $command->phone
        );

        $this->entityManager->flush();

        $lock->release();
    }

    public function checkLockAvailability(SharedLockInterface $lock): bool
    {
        for (;$this->waitingCount++ < $this->waitingLimit;) {
            if ($lock->acquire()) {
                return true;
            }

            sleep($this->waitingInterval);
        }

        return false;
    }
}