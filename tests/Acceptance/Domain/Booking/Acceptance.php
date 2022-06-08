<?php

namespace App\Tests\Acceptance\Domain\Booking;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class Acceptance extends WebTestCase
{
    const FORM_SEND = 'form';

    public static function getClient(): KernelBrowser
    {
        self::ensureKernelShutdown();
        return static::createClient();
    }

    protected function httpRequest(KernelBrowser $client, string $method, string $endpoint, ?string $type = null, $content = null): Crawler
    {
        if (\is_array($content)) {
            $content = json_encode($content);
        }

        return $client->request(
            $method,
            $endpoint,
            [],
            [],
            $this->getHeaders($type),
            $content
        );
    }

    private function getHeaders(?string $type): array
    {
        return match ($type) {
            self::FORM_SEND => [
                'CONTENT_TYPE' => 'application/x-www-form-urlencoded',
            ],
            default => [],
        };
    }
}
