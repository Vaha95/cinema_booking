<?php

namespace App\Domain\Booking\Validator\Constraint;

use App\Domain\Booking\Entity\Session;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class PlacesRequestExist extends Constraint
{
    public string $message = 'Свободно мест: {{ free }}, Запрошено мест: {{ require }}';
    public string $messageNotReadable = 'Переданы не все поля.';
    public ?string $requiredPlacesField;
    public ?string $sessionField;

    public function getRequiredOptions(): array
    {
        return ['requiredPlacesField', 'sessionField'];
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}