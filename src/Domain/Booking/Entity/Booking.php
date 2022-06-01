<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Entity\ValueObject\Customer;
use App\Domain\Booking\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
#[ORM\Table(name: 'booking')]
class Booking
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    private Uuid $id;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $bookingDateTime;

    #[ORM\Embedded(class: 'App\Domain\Booking\Entity\ValueObject\Customer', columnPrefix: 'customer_')]
    private Customer $customer;

    #[ORM\Column(type: 'integer')]
    private int $countOfSeats;

    #[ORM\ManyToOne(targetEntity: Session::class, inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private Session $session;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getBookingDateTime(): \DateTimeImmutable
    {
        return $this->bookingDateTime;
    }

    public function getCountOfSeats(): int
    {
        return $this->countOfSeats;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getSession(): Session
    {
        return $this->session;
    }

    private function setBookingDateTime(\DateTimeImmutable $bookingDateTime): void
    {
        $this->bookingDateTime = $bookingDateTime;
    }

    private function setCountOfSeats(int $countOfSeats): void
    {
        $this->countOfSeats = $countOfSeats;
    }

    private function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    private function setSession(?Session $session): void
    {
        $this->session = $session;
    }
}
