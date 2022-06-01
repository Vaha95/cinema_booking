<?php

namespace App\Domain\Booking\Entity\ValueObject;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Customer
{
    #[ORM\Column(type: 'string', length: 255)]
    private readonly string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private readonly string $phone;

    public function __construct(string $name, string $phone)
    {
        $this->name = $name;
        $this->phone = $phone;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }
}
