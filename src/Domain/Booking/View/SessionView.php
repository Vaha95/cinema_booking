<?php

namespace App\Domain\Booking\View;

use App\Domain\Booking\Exception\NotPositiveRealNumberException;
use App\Domain\Booking\Assertion\PositiveRealNumberAssertion;
use Symfony\Component\Uid\Uuid;

class SessionView
{
    public readonly string $startAt;
    public readonly string $endAt;
    public readonly string $date;
    public readonly string $duration;

    const HOURS_AND_MINUTES_DATETIME_FORMAT = 'H:i';
    const RUS_MONTHS_DICTIONARY = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];

    /**
     * @throws \Exception
     * @throws NotPositiveRealNumberException
     */
    public function __construct(public readonly Uuid $id, public readonly string $name, public readonly int $freePlaces, \DateTimeImmutable $startAt, int $duration)
    {
        PositiveRealNumberAssertion::assert($duration);

        $preTransformEndAt = new \DateTime($startAt->format(\DateTimeInterface::ATOM));

        $this->startAt = $startAt->format('H:i');
        $this->endAt = $preTransformEndAt
            ->modify(sprintf('+ %d minutes', $duration))
            ->format(self::HOURS_AND_MINUTES_DATETIME_FORMAT);
        $this->date = $this->dateToStringFormatter($startAt);
        $this->duration = $this->getDuration($duration);
    }

    private function getDuration(int $duration): string
    {
        $hours = floor($duration / 60);
        $minutes = $duration % 60;

        return $this->timeToStringFormatter($hours, $minutes);
    }

    private function dateToStringFormatter(\DateTimeImmutable $dateTime): string
    {
        return sprintf('%d %s',
            $dateTime->format('d'),
            self::RUS_MONTHS_DICTIONARY[$dateTime->format('m') - 1]
        );
    }

    private function timeToStringFormatter(int $hours, int $minutes): string
    {
        return sprintf('%d ч %d м', $hours, $minutes);
    }
}