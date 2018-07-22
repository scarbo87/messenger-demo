<?php

namespace App\EnvelopeItem;

use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\EnvelopeItemInterface;

class IdItem implements EnvelopeItemInterface
{
    private $uuid;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4()->toString();
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function serialize(): string
    {
        return $this->uuid;
    }

    public function unserialize($serialized): void
    {
        $this->uuid = $serialized;
    }
}