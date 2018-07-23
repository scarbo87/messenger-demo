<?php

namespace App\MessageHandler\Gitlab;

use App\EnvelopeItem\AuditItem;
use App\EnvelopeItem\ParentMessage;
use App\Message\Gitlab\MrMessage;
use App\Message\Jira\TransitionMessage;
use App\MessageHandler\HandlerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class MRMessageHandler implements HandlerInterface
{
    private $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(MrMessage $message): void
    {
        // ... анализируем данные из gitlab
        // ... и получаем issue key
        $issueKey = $message->getSourceBranch();

        $this->bus->dispatch(
            (new Envelope(new TransitionMessage(42, $issueKey)))
                ->with(new ParentMessage($message))
        );
    }
}