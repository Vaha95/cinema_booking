<?php

namespace App\Tests\Unit\Domain\Booking\Entity;

use App\Domain\Booking\Entity\Booking;
use App\Domain\Booking\Entity\Film;
use App\Domain\Booking\Entity\Session;
use App\Domain\Booking\Entity\ValueObject\Customer;
use App\Domain\Booking\Exception\NotPositiveRealNumberException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;
use TypeError;

class BookingTest extends TestCase
{
    public function testCustomerValidate(): void
    {
        $id = Uuid::v4();
        $countOfSeats = 4;
        $customer = $this->createMock(Customer::class);
        $session = $this->createMock(Session::class);

        $booking = new Booking($id, $countOfSeats, $customer, $session);

        $this->assertEquals($id, $booking->getId());
        $this->assertEquals($session, $booking->getSession());
        $this->assertEquals($customer, $booking->getCustomer());
        $this->assertEquals($countOfSeats, $booking->getCountOfSeats());
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
        $countOfSeats = 4;
        $customer = $this->createMock(Customer::class);
        $session = $this->createMock(Session::class);

        yield [
            'arguments' => ['uuid', $countOfSeats, $customer, $session],
            'exception' => TypeError::class,
        ];
        yield [
            'arguments' => [$id, null, $customer, $session],
            'exception' => TypeError::class,
        ];
        yield [
            'arguments' => [$id, [], $customer, $session],
            'exception' => TypeError::class,
        ];
        yield [
            'arguments' => [$id, $countOfSeats, null, $session],
            'exception' => TypeError::class,
        ];
        yield [
            'arguments' => [$id, $countOfSeats, [], $session],
            'exception' => TypeError::class,
        ];
        yield [
            'arguments' => [$id, $countOfSeats, $customer, null],
            'exception' => TypeError::class,
        ];
        yield [
            'arguments' => [$id, $countOfSeats, $customer, []],
            'exception' => TypeError::class,
        ];
        yield [ // Перепутаны сессия и заказчик
            'arguments' => [$id, $countOfSeats, $session, $customer],
            'exception' => TypeError::class,
        ];
        yield [
            'arguments' => [$id, -80, $session, $customer],
            'exception' => NotPositiveRealNumberException::class,
        ];
    }
}
