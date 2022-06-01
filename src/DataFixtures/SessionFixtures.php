<?php

namespace App\DataFixtures;

use App\Domain\Booking\Entity\CinemaHall;
use App\Domain\Booking\Entity\Factory\SessionFactory;
use App\Domain\Booking\Entity\Film;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SessionFixtures extends Fixture implements DependentFixtureInterface
{
    public const FIXTURE_DATA = [
        ['startAt' => 10, 'film' => FilmFixtures::FIXTURE_DATA[4]['name'], 'cinemaHall'=> CinemaHallFixtures::FIXTURE_DATA[2]['reference'], 'reference' => 'session_1'],
        ['startAt' => 16, 'film' => FilmFixtures::FIXTURE_DATA[1]['name'], 'cinemaHall'=> CinemaHallFixtures::FIXTURE_DATA[0]['reference'], 'reference' => 'session_2'],
        ['startAt' => 7, 'film' => FilmFixtures::FIXTURE_DATA[2]['name'], 'cinemaHall'=> CinemaHallFixtures::FIXTURE_DATA[1]['reference'], 'reference' => 'session_3'],
    ];

    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        foreach (self::FIXTURE_DATA as $sessionData) {
            /* @var Film $film */
            $film = $this->getReference($sessionData['film']);
            /* @var CinemaHall $cinemaHall */
            $cinemaHall = $this->getReference($sessionData['cinemaHall']);
            $startAt = new \DateTimeImmutable(sprintf('+%d days', $sessionData['startAt']), new \DateTimeZone('Europe/Moscow'));

            $session = SessionFactory::create($film, $cinemaHall, $startAt);

            $manager->persist($session);
            $this->addReference($sessionData['reference'], $session);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            FilmFixtures::class,
            CinemaHallFixtures::class,
        ];
    }
}
