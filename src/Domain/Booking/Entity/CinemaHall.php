<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Assertion\PositiveRealNumberAssertion;
use App\Domain\Booking\Repository\CinemaHallRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CinemaHallRepository::class)]
class CinemaHall
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    private Uuid $id;

    #[ORM\Column(type: 'integer')]
    private int $hallCapacity;

    #[ORM\OneToMany(mappedBy: 'cinemaHall', targetEntity: Session::class)]
    private Collection $sessions;

    public function __construct(Uuid $id, int $hallCapacity)
    {
        PositiveRealNumberAssertion::assert($hallCapacity);

        $this->id = $id;
        $this->hallCapacity = $hallCapacity;
        $this->sessions = new ArrayCollection();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getHallCapacity(): int
    {
        return $this->hallCapacity;
    }

    public function getSessions(): Collection
    {
        return $this->sessions;
    }
}
