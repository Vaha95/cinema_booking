<?php

namespace App\Tests\Unit\Domain\Booking\Entity;

use App\Domain\Booking\Entity\CinemaHall;
use App\Domain\Booking\Entity\Film;
use App\Domain\Booking\Entity\Session;
use App\Domain\Booking\Exception\InsufficientlyFreePlacesException;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;
use TypeError;

class SessionTest extends TestCase
{
    public function testBookingMethodFail(): void
    {
        $this->expectException(InsufficientlyFreePlacesException::class);

        $id = Uuid::v4();
        $startAt = new \DateTimeImmutable();
        $film = $this->createMock(Film::class);
        $cinemaHall = $this->createMock(CinemaHall::class);
        $places = 80;

        $cinemaHall
            ->method('getHallCapacity')
            ->willReturn($places);

        $session = new Session($id, $film, $cinemaHall, $startAt);
        $session->bookingOrder(180, 'Test', '9001002030');
    }

    public function testBookingMethod(): void
    {
        $id = Uuid::v4();
        $startAt = new \DateTimeImmutable();
        $film = $this->createMock(Film::class);
        $cinemaHall = $this->createMock(CinemaHall::class);
        $places = 80;
        $bookPlaces = 10;

        $cinemaHall
            ->method('getHallCapacity')
            ->willReturn($places);

        $session = new Session($id, $film, $cinemaHall, $startAt);

        $session->bookingOrder($bookPlaces, 'Test', '9001002030');

        $this->assertEquals($places - $bookPlaces, $session->getFreePlaces());
        $this->assertCount(1, $session->getBookings());

    }

    public function testSessionCreated(): void
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
     * @dataProvider sessionCreatedFailDataProvider
     */
    public function testSessionCreatedFail(array $arguments): void
    {
        $this->expectException(TypeError::class);

        new Film(...$arguments);
    }

    public function sessionCreatedFailDataProvider(): \Generator
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
