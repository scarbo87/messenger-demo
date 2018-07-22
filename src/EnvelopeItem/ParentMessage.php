<?php

namespace App\EnvelopeItem;

use Symfony\Component\Messenger\EnvelopeItemInterface;

class ParentMessage implements EnvelopeItemInterface
{
    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function serialize(): string
    {
        return serialize($this->message);
    }

    public function unserialize($serialized): void
    {
        $this->message = unserialize($serialized, ['allowed_classes' => false]);
    }
}