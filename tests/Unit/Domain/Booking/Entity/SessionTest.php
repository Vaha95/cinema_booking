<?php

namespace App\Tests\Unit\Domain\Booking\Entity;

use App\Domain\Booking\Entity\CinemaHall;
use App\Domain\Booking\Entity\Film;
use App\Domain\Booking\Entity\Session;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;
use TypeError;

class SessionTest extends TestCase
{
    public function testCustomerValidate(): void
    {
        $id = Uuid::v4();
        $startAt = new \DateTimeImmutable();
        $film = $this->createMock(Film::class);
        $cinemaHall = $this->createMock(CinemaHall::class);
        $places = 80;

        $cinemaHall
            ->method('getHallCapacity')
            ->willReturn($places);

        $session = new Session($id, $film, $cinemaHall, $startAt);

        $this->assertEquals($id, $session->getId());
        $this->assertEquals($film, $session->getFilm());
        $this->assertEquals($startAt, $session->getStartAt());
        $this->assertEquals($places, $session->getFreePlaces());
        $this->assertEquals($cinemaHall, $session->getCinemaHall());
        $this->assertEquals(new ArrayCollection(), $session->getBookings());
    }

    /**
     * @dataProvider customerValidateFailDataProvider
     */
    public function testCustomerValidateFail(array $arguments): void
    {
        $this->expectException(TypeError::class);

        new Film(...$arguments);
    }

    public function customerValidateFailDataProvider(): \Generator
    {
        $id = Uuid::v4();
        $startAt = new \DateTimeImmutable();
        $film = $this->createMock(Film::class);
        $cinemaHall = $this->createMock(CinemaHall::class);

        yield [
            'arguments' => [$id, $film, $cinemaHall, new \DateTime()]
        ];
        yield [
            'arguments' => [$id, null, $cinemaHall, $startAt]
        ];
        yield [
            'arguments' => [$id, $film, null, $startAt]
        ];
        yield [
            'arguments' => [$id, 'film', $cinemaHall, $startAt]
        ];
        yield [
            'arguments' => [$id, $film, 77, $startAt]
        ];
        yield [
            'arguments' => ['uuid', $film, $cinemaHall, $startAt]
        ];
    }
}
