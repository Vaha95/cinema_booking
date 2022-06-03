<?php

namespace App\Domain\Booking\Entity\ValueObject;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Customer
{
    #[ORM\Column(type: 'string', length: 255)]
    public readonly string $name;

    #[ORM\Column(type: 'string', length: 255)]
    public readonly string $phone;

    public function __construct(string $name, string $phone)
    {
        $this->name = $name;
        $this->phone = $phone;
    }
}
