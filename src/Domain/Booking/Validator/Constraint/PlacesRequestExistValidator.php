<?php

namespace App\Domain\Booking\Validator\Constraint;

use App\Domain\Booking\Entity\Session;
use InvalidArgumentException;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PlacesRequestExistValidator extends ConstraintValidator
{
    public function __construct(private PropertyAccessorInterface $propertyAccessor)
    {
    }

     /**
      * @inheritDoc
      */
    public function validate($value, Constraint $constraint): void
    {
        self::assertConstraintInstanceOfPlacesRequestExist($constraint);

        if (!$this->propertyAccessor->isReadable($value, $constraint->requiredPlacesField) || !$this->propertyAccessor->isReadable($value, $constraint->sessionField)) {
            $this->context->addViolation($constraint->messageNotReadable, []);
            return;
        }

        /** @var int|null $requiredPlaces */
        $requiredPlaces = $this->propertyAccessor->getValue($value, $constraint->requiredPlacesField);
        /** @var Session|null $session */
        $session = $this->propertyAccessor->getValue($value, $constraint->sessionField);

        try {
            $session->assertCanBookOrder($requiredPlaces);
        } catch (\Exception $exception) {
            $this->context->addViolation(
                $constraint->message,
                [
                    '{{ require }}' => $requiredPlaces,
                    '{{ free }}' => $session->getFreePlaces(),
                ]
            );
        }
    }

    private static function assertConstraintInstanceOfPlacesRequestExist(Constraint $constraint): void
    {
        if (!$constraint instanceof PlacesRequestExist) {
            throw new InvalidArgumentException(sprintf(
                'Constraint must be instance of %s, %s provided',
                PlacesRequestExist::class,
                get_class($constraint)
            ));
        }
    }
}