<?php

namespace App\Factory;

use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Lock\Store\FlockStore;

class FlockFactory
{
    private const LOCK_STORAGE_PATH = '/var/stores';

    public static function create(): LockFactory
    {
        $store = new FlockStore(self::LOCK_STORAGE_PATH);
        return new LockFactory($store);
    }
}