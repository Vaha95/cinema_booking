<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Entity\TransferObject\FilmDTO;
use App\Domain\Booking\Repository\FilmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilmRepository::class)]
class Film
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToMany(mappedBy: 'film', targetEntity: Session::class)]
    private $sessions;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $duration;

    public function __construct(FilmDTO $filmDTO)
    {
        $this->sessions = new ArrayCollection();
        $this->setName($filmDTO->name);
        $this->setDuration($filmDTO->duration);
    }

    public function getId(): ?int
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

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setFilm($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getFilm() === $this) {
                $session->setFilm(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }
}
