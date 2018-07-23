<?php

namespace App\Middleware;

use Psr\Cache\CacheItemPoolInterface;

class AuditMiddlewareFactory
{
    private $cache;

    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    public function createProduceAuditMiddleware(string $lifetime): ProduceAuditMiddleware
    {
        return new ProduceAuditMiddleware($this->cache, $lifetime);
    }

    public function createConsumeAuditMiddleware(string $lifetime): ConsumeAuditMiddleware
    {
        return new ConsumeAuditMiddleware($this->cache, $lifetime);
    }
}