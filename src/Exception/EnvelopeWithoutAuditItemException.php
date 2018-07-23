<?php

namespace App\Exception;

use Symfony\Component\Messenger\Envelope;

class EnvelopeWithoutAuditItemException extends \RuntimeException
{
    private $envelope;

    public function __construct(Envelope $envelope)
    {
        parent::__construct('Envelope without AuditItem');
        $this->envelope = $envelope;
    }

    public function getEnvelope(): Envelope
    {
        return $this->envelope;
    }
}