<?php

namespace App\Domain\Booking\Command;

use App\Domain\Booking\Entity\Session;
use Symfony\Component\Validator\Constraints as Assert;

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