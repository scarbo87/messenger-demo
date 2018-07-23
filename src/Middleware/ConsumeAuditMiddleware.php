<?php

namespace App\Middleware;

use App\EnvelopeItem\AuditItem;
use App\Exception\DeduplicationException;
use App\Exception\EnvelopeWithoutAuditItemException;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\EnvelopeAwareInterface;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;

class ConsumeAuditMiddleware implements MiddlewareInterface, EnvelopeAwareInterface
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
     * @throws \Throwable
     */
    public function handle($envelope, callable $next)
    {
        /** @var AuditItem $auditItem */
        $auditItem = $envelope->get(AuditItem::class);
        if (null === $auditItem) {
            throw new EnvelopeWithoutAuditItemException($envelope);
        }

        // TODO - проверки, что это не ретрай, а если requeue, то его не обрабатывает какой-либо консьюмер
        $cacheItem = $this->cache->getItem($auditItem->getUuid());
        unset($auditItem);

        if (!$cacheItem->isHit()) {
            throw new EnvelopeWithoutAuditItemException($envelope);
        }

        /** @var AuditItem $auditItem */
        $auditItem = $cacheItem->get();
        if ($auditItem->getStatus() > AuditItem::PUBLISHED) {
            throw new DeduplicationException(sprintf('Envelope with uuid `%s`is already being processed!', $auditItem->getUuid()));
        }

        $auditItem->setStatus(AuditItem::IN_PROGRESS);
        $cacheItem->set($auditItem);
        $this->cache->save($cacheItem);

        $envelope = $envelope->with($auditItem);

        try {
            $returnValue = $next($envelope);

            $auditItem->setStatus(AuditItem::COMPLETED);
            $cacheItem->set($auditItem);
            $this->cache->save($cacheItem);

            return $returnValue;
        } catch (\Throwable $e) {
            $auditItem->setStatus(AuditItem::FAILED);
            $cacheItem->set($auditItem);
            $this->cache->save($cacheItem);

            throw $e;
        }
    }
}