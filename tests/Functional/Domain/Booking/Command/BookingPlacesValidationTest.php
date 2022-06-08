<?php

namespace App\Tests\Functional\Domain\Booking\Command;

use App\Tests\Functional\Domain\Booking\TestCase;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use TypeError;

class BookingPlacesValidationTest extends TestCase
{
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
        $em = $this->getEntityManager();
        $session = $this->getSession($em);

        yield [
            'arguments' => [$session, 'TestName', null, 1, $em],
            'exception' => TypeError::class,
        ];
        yield [
            'arguments' => [$session, null, '9017007080', 1, $em],
            'exception' => TypeError::class,
        ];
        yield [
            'arguments' => [null, 'TestName', '9017007080', 1, $em],
            'exception' => TypeError::class,
        ];
        yield [
            'arguments' => [$session, 'TestName', '9017007080', -1, $em],
            'exception' => HandlerFailedException::class,
        ];
    }
}
