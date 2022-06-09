<?php

namespace App\Domain\Booking\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class PlacesRequestExist extends Constraint
{
    public string $message = 'Свободно мест: {{ free }}, Запрошено мест: {{ require }}';
    public string $messageNotReadable = 'Переданы не все поля.';
    public ?string $requiredPlacesField;
    public ?string $sessionField;

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}