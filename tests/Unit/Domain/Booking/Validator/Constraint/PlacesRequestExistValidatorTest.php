<?php

namespace App\Tests\Unit\Domain\Booking\Validator\Constraint;

use App\Domain\Booking\Entity\Session;
use App\Domain\Booking\Exception\InsufficientlyFreePlacesException;
use App\Domain\Booking\Validator\Constraint\PlacesRequestExist;
use App\Domain\Booking\Validator\Constraint\PlacesRequestExistValidator;
use App\Tests\Unit\Mock\ValidatorExecutionContextMock;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Validator\Constraint;
use TypeError;

class PlacesRequestExistValidatorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->constraint = new PlacesRequestExist();

        $this->constraint->requiredPlacesField = 'requiredPlaces';
        $this->constraint->sessionField = 'session';

        $this->validator = new PlacesRequestExistValidator(new PropertyAccessor());
        $this->executionContext = new ValidatorExecutionContextMock();

        $this->validator->initialize($this->executionContext);
    }

    protected function tearDown(): void
    {
        unset(
            $this->validator,
            $this->constraint,
            $this->executionContext
        );

        parent::tearDown();
    }

    public function testInstance(): void
    {
        $session = $this->createMock(Session::class);
        $this->expectException(InvalidArgumentException::class);

        $this->validator->validate((object) ['requiredPlacesField' => 20, 'sessionField' => $session], $this->createMock(Constraint::class));
    }

    public function testNotEnoughFreePlaces(): void
    {
        $session = $this->createMock(Session::class);
        $session->method('assertCanBookOrder')->willThrowException(new InsufficientlyFreePlacesException());

        $this->validator->validate((object) ['requiredPlaces' => 20, 'session' => $session], $this->constraint);
        $this->assertTrue($this->executionContext->hasViolations());
    }

    public function testBookFreePlaces(): void
    {
        $session = $this->createMock(Session::class);
        $session->method('getFreePlaces')->willReturn(32);

        $this->validator->validate((object) ['requiredPlaces' => 20, 'session' => $session], $this->constraint);
        $this->assertFalse($this->executionContext->hasViolations());
    }
}
