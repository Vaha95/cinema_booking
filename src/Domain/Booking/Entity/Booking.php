<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Entity\ValueObject\Customer;
use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
#[ORM\Table(name: 'booking')]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime_immutable')]
    private $bookingDateTime;

    #[ORM\Embedded(class: 'App\Domain\Booking\Entity\ValueObject\Customer', columnPrefix: 'customer_')]
    private $customer;

    #[ORM\Column(type: 'integer')]
    private $numberOfSeats;

    #[ORM\ManyToOne(targetEntity: Session::class, inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private $session;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookingDateTime(): ?\DateTimeImmutable
    {
        return $this->bookingDateTime;
    }

    public function setBookingDateTime(\DateTimeImmutable $bookingDateTime): self
    {
        $this->bookingDateTime = $bookingDateTime;

        return $this;
    }

    public function getNumberOfSeats(): ?int
    {
        return $this->numberOfSeats;
    }

    public function setNumberOfSeats(int $numberOfSeats): self
    {
        $this->numberOfSeats = $numberOfSeats;

        return $this;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): self
    {
        $this->session = $session;

        return $this;
    }
}
