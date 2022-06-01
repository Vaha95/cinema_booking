<?php

namespace App\DataFixtures;

use App\Domain\Booking\Entity\Factory\CinemaHallFactory;
use App\Domain\Booking\Exception\NotPositiveRealNumberException;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CinemaHallFixtures extends Fixture
{
    public const FIXTURE_DATA = [
        ['hallCapacity' => 100, 'reference' => 'cinema_hall_1'],
        ['hallCapacity' => 40, 'reference' => 'cinema_hall_2'],
        ['hallCapacity' => 74, 'reference' => 'cinema_hall_3'],
    ];

    /**
     * @param ObjectManager $manager
     *
     * @throws NotPositiveRealNumberException
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        foreach (self::FIXTURE_DATA as $cinemaHallData) {
            $cinemaHall = CinemaHallFactory::create($cinemaHallData['hallCapacity']);

            $manager->persist($cinemaHall);
            $this->addReference($cinemaHallData['reference'], $cinemaHall);
        }
        $manager->flush();
    }
}
