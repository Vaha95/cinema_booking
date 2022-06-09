<?php

namespace App\Tests\Unit\Domain\Booking\Entity\ValueObject;

use App\Domain\Booking\Entity\ValueObject\Customer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\Uuid;
use TypeError;

class CustomerTest extends TestCase
{
    public function testCustomerValidate(): void
    {
        $this->expectNotToPerformAssertions();

        new Customer('Ivan', '9018007080');
    }

    /**
     * @dataProvider customerValidateFailDataProvider
     */
    public function testCustomerValidateFail(array $arguments): void
    {
        $this->expectException(TypeError::class);

        new Customer(...$arguments);
    }

    public function customerValidateFailDataProvider(): \Generator
    {
        yield [
            'arguments' => [[], new Uuid()]
        ];
        yield [
            'arguments' => [432423, null]
        ];
        yield [
            'arguments' => [[new Uuid()], 'Hello']
        ];
    }
}
