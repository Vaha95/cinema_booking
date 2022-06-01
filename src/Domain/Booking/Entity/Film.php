<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Entity\TransferObject\FilmDTO;
use App\Domain\Booking\Repository\FilmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: FilmRepository::class)]
class Film
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    private Uuid $id;

    #[ORM\OneToMany(mappedBy: 'film', targetEntity: Session::class)]
    private Collection $sessions;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $name;

    #[ORM\Column(type: 'integer')]
    private int $duration;

    public function __construct(FilmDTO $filmDTO)
    {
        $this->sessions = new ArrayCollection();
        $this->setId($filmDTO->id);
        $this->setName($filmDTO->name);
        $this->setDuration($filmDTO->duration);
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    private function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    private function setName(string $name): void
    {
        $this->name = $name;
    }

    private function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }
}
