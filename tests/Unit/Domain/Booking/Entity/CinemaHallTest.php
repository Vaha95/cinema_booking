<?php

namespace App\Tests\Unit\Domain\Booking\Entity;

use App\Domain\Booking\Entity\CinemaHall;
use App\Domain\Booking\Exception\NotPositiveRealNumberException;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;
use TypeError;

class CinemaHallTest extends TestCase
{
    public function testCustomerValidate(): void
    {
        $id = Uuid::v4();
        $hallCapacity = 80;

        $cinemaHall = new CinemaHall($id, $hallCapacity);

        $this->assertEquals($id, $cinemaHall->getId());
        $this->assertEquals($hallCapacity, $cinemaHall->getHallCapacity());
        $this->assertEquals(new ArrayCollection(), $cinemaHall->getSessions());
    }

    /**
     * @dataProvider customerValidateFailDataProvider
     */
    public function testCustomerValidateFail(array $arguments, string $exception): void
    {
        $this->expectException($exception);

        new CinemaHall(...$arguments);
    }

    public function customerValidateFailDataProvider(): \Generator
    {
        yield [
            'arguments' => [[], new \DateTimeImmutable()],
            'exception' => TypeError::class,
        ];
        yield [
            'arguments' => [Uuid::v4(), null],
            'exception' => TypeError::class,
        ];
        yield [
            'arguments' => [[new \DateTime()], 75],
            'exception' => TypeError::class,
        ];
        yield [
            'arguments' => [Uuid::v4(), -70],
            'exception' => NotPositiveRealNumberException::class,
        ];
    }
}
