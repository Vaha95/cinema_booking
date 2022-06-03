<?php

namespace App\Domain\Booking\Repository;

use App\Domain\Booking\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 */
class SessionRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }
}
