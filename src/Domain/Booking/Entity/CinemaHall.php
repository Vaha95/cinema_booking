<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Entity\TransferObject\CinemaHallDTO;
use App\Repository\CinemaHallRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CinemaHallRepository::class)]
class CinemaHall
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $hallCapacity;

    #[ORM\OneToMany(mappedBy: 'cinemaHall', targetEntity: Session::class)]
    private $sessions;

    public function __construct(CinemaHallDTO $cinemaHallDTO)
    {
        $this->sessions = new ArrayCollection();
        $this->setHallCapacity($cinemaHallDTO->hallCapacity);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHallCapacity(): ?int
    {
        return $this->hallCapacity;
    }

    public function setHallCapacity(int $hallCapacity): self
    {
        $this->hallCapacity = $hallCapacity;

        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setCinemaHall($this);
        }

        return $this;
    }
}
