<?php

namespace App\Domain\Booking\Repository;

use App\Domain\Booking\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 *
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    public function findAllAgregate()
    {
        $qb = $this->createQueryBuilder('session');

        $select = sprintf(
            'session.startAt, film.duration, film.name, (%s) AS freePlaces',
            $this->queryFreePlacesCount()
        );

        $qb
            ->select($select)
            ->innerJoin('session.film', 'film')
        ->where('session.startAt > :currentDate')
        ->setParameter(':currentDate', ((new \DateTime())->format('Y-m-d')));

        return $qb->getQuery()->getResult();
    }

    /**
     * Запрос на получение количества свободных мест на сеансе.
     */
    private function queryFreePlacesCount(): string
    {
        $qb = $this->createQueryBuilder('subSession');

        $qb
            ->select('(cinema_hall.hallCapacity - COALESCE(SUM(bookings.countOfSeats), 0))')
            ->innerJoin('subSession.cinemaHall', 'cinema_hall')
            ->leftJoin('subSession.bookings', 'bookings')
            ->groupBy('subSession.id')
            ->having('session.id = subSession.id');
        return $qb->getDQL();
    }
}
