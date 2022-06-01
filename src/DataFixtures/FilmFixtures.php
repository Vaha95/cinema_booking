<?php

namespace App\DataFixtures;

use App\Domain\Booking\Entity\Factory\FilmFactory;
use App\Domain\Booking\Exception\NotPositiveRealNumberException;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FilmFixtures extends Fixture
{
    public const FIXTURE_DATA = [
        ['name' => 'Ромашки - цветочки', 'duration' => 110],
        ['name' => 'Васильки - бабочки', 'duration' => 130],
        ['name' => 'Фантастический мир', 'duration' => 114],
        ['name' => 'Необычный фильм', 'duration' => 120],
        ['name' => 'Кошечки - собачки', 'duration' => 110],
        ['name' => 'Лето', 'duration' => 101],
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
        foreach (self::FIXTURE_DATA as $key => $filmData) {
            $film = FilmFactory::create($filmData['name'], $filmData['duration']);

            $manager->persist($film);
            $this->addReference($filmData['name'], $film);
        }
        $manager->flush();
    }
}
