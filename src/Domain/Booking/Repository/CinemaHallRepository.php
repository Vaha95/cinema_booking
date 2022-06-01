<?php

namespace App\Domain\Booking\Repository;

use App\Domain\Booking\Entity\CinemaHall;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CinemaHall>
 */
class CinemaHallRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CinemaHall::class);
    }
}
