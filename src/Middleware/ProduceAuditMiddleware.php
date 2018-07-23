<?php

namespace App\Middleware;

use App\EnvelopeItem\AuditItem;
use App\Exception\DeduplicationException;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\EnvelopeAwareInterface;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;

class ProduceAuditMiddleware implements MiddlewareInterface, EnvelopeAwareInterface
{
    private $cache;
    private $lifetime;

    public function __construct(CacheItemPoolInterface $cache, ?string $lifetime)
    {
        $this->cache = $cache;
        $this->lifetime = $lifetime ?? 'PT1H';
    }

    /**
     * @param Envelope $envelope
     * @param callable $next
     *
     * @return mixed
     */
    public function handle($envelope, callable $next)
    {
        $auditItem = new AuditItem(null, null, null);
        $envelope = $envelope->with($auditItem);

        $cacheItem = $this->cache->getItem($auditItem->getUuid());
        if ($cacheItem->isHit()) {
            throw new DeduplicationException(sprintf('Envelope with uuid `%s`is already being published!', $auditItem->getUuid()));
        }

        // TODO - нужна нормальная структура для redis для быстрого поиска
        $cacheItem->set($auditItem);
        $cacheItem->expiresAfter(new \DateInterval($this->lifetime));
        $this->cache->save($cacheItem);

        $returnValue = $next($envelope);

        $auditItem->setStatus(AuditItem::PUBLISHED);
        $cacheItem->set($auditItem);
        $this->cache->save($cacheItem);

        return $returnValue;
    }

}