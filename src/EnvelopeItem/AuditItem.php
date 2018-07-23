<?php

namespace App\EnvelopeItem;

use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\EnvelopeItemInterface;

class AuditItem implements EnvelopeItemInterface
{
    public const PREPUBLISHED = 0;
    public const PUBLISHED = 1;
    public const IN_PROGRESS = 2;
    public const COMPLETED = 3;
    public const FAILED = 4;

    private $uuid;
    private $datetime;
    private $status;

    public function __construct(?string $uuid, ?int $status, ?\DateTimeInterface $datetime)
    {
        $this->uuid = $uuid ?? Uuid::uuid4()->toString();
        $this->status = $status ?? self::PREPUBLISHED;
        $this->datetime = $datetime ?? new \DateTimeImmutable();
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getDatetime(): \DateTimeInterface
    {
        return $this->datetime;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function serialize(): string
    {
        return json_encode(['uuid' => $this->uuid, 'status' => $this->status, 'datetime' => $this->datetime->format(\DateTime::RFC3339)]);
    }

    public function unserialize($serialized): void
    {
        ['uuid' => $uuid, 'status' => $status, 'datetime' => $datetime] = json_decode($serialized, true);
        $this->__construct($uuid, $status, \DateTime::createFromFormat(\DateTime::RFC3339, $datetime));
    }
}