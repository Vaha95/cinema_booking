<?php

namespace App\Domain\Booking\Command;

use App\Domain\Booking\Entity\Session;
use App\Domain\Booking\Validator\Constraint\PlacesRequestExist;
use Symfony\Component\Validator\Constraints as Assert;

#[PlacesRequestExist(options: ['requiredPlacesField' => 'places', 'sessionField' => 'session'])]
class BookingCommand
{
    #[Assert\NotBlank]
    #[Assert\Type(type: "integer")]
    public int $places;
    #[Assert\NotBlank]
    #[Assert\Length(max: 255, maxMessage: "Длина не должна превышать {{ limit }} символов")]
    public string $name;
    #[Assert\NotBlank]
    #[Assert\Length(max: 255, maxMessage: "Длина не должна превышать {{ limit }} символов")]
    public string $phone;
    #[Assert\NotNull]
    #[Assert\Type(type: "App\Domain\Booking\Entity\Session")]
    public Session $session;
}