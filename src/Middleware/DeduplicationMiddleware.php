<?php

namespace App\Middleware;

use App\EnvelopeItem\IdItem;
use App\Exception\DeduplicationException;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Messenger\EnvelopeAwareInterface;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;

class DeduplicationMiddleware implements MiddlewareInterface, EnvelopeAwareInterface
{
    private const LIFETIME = 'PT1H';

    private $cache;

    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    public function handle($envelope, callable $next)
    {
        /** @var IdItem $idItem */
        $idItem = $envelope->get(IdItem::class);
        if (null === $idItem) {
            return $next($envelope);
        }

        // ... тут куча проверок, что это не ретрай, а если requeue, то его не обрабатывает какой-либо консьюмер
        $cacheItem = $this->cache->getItem($idItem->getUuid());
        if (!$cacheItem->isHit()) {
            $cacheItem->set(true);
            $cacheItem->expiresAfter(new \DateInterval(self::LIFETIME));
            $this->cache->save($cacheItem);

            return $next($envelope);
        }

        throw new DeduplicationException(sprintf('Envelope with uuid `%s`is already being processed!', $idItem->getUuid()));
    }
}