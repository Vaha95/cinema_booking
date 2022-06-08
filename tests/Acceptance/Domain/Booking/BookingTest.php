<?php

namespace App\Tests\Acceptance\Domain\Booking;

class BookingTest extends Acceptance
{
    public function testGetAllSessions(): void
    {
        $client = $this->getClient();
        $this->httpRequest($client, 'GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'text/html; charset=UTF-8');
        $this->assertSelectorTextContains('h2', 'Доступные сеансы');
        $this->assertSelectorTextContains('a', 'Инфо');
    }

    public function testBooking(): void
    {
        $client = $this->getClient();
        $this->httpRequest($client, 'POST', '/booking', Acceptance::FORM_SEND, []);

        $this->assertResponseHeaderSame('content-type', 'text/html; charset=UTF-8');
        $this->assertSelectorTextContains('h3', 'Некорректные входные данные');
    }
}
