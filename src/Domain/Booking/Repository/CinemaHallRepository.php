<?php

namespace App\Domain\Booking\Repository;

use App\Domain\Booking\Entity\CinemaHall;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CinemaHall>
 *
 * @method CinemaHall|null find($id, $lockMode = null, $lockVersion = null)
 * @method CinemaHall|null findOneBy(array $criteria, array $orderBy = null)
 * @method CinemaHall[]    findAll()
 * @method CinemaHall[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CinemaHallRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CinemaHall::class);
    }
}
