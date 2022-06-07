<?php

namespace App\Tests\Unit\Domain\Booking\Entity;

use App\Domain\Booking\Entity\CinemaHall;
use App\Domain\Booking\Entity\Film;
use App\Domain\Booking\Exception\NotPositiveRealNumberException;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;
use TypeError;

class FilmTest extends TestCase
{
    public function testCustomerValidate(): void
    {
        $id = Uuid::v4();
        $name = 'Test film name';
        $duration = 120;

        $film = new Film($id, $name, $duration);

        $this->assertEquals($id, $film->getId());
        $this->assertEquals($name, $film->getName());
        $this->assertEquals($duration, $film->getDuration());
        $this->assertEquals(new ArrayCollection(), $film->getSessions());
    }

    /**
     * @dataProvider customerValidateFailDataProvider
     */
    public function testCustomerValidateFail(array $arguments, string $exception): void
    {
        $this->expectException($exception);

        new Film(...$arguments);
    }

    public function customerValidateFailDataProvider(): \Generator
    {
        yield [
            'arguments' => [[], 'test text', 90],
            'exception' => TypeError::class,
        ];
        yield [
            'arguments' => [Uuid::v4(), null, 90],
            'exception' => TypeError::class,
        ];
        yield [
            'arguments' => [Uuid::v4(), [new \DateTime()], 75],
            'exception' => TypeError::class,
        ];
        yield [
            'arguments' => [Uuid::v4(), 'test text', -70],
            'exception' => NotPositiveRealNumberException::class,
        ];
    }
}
