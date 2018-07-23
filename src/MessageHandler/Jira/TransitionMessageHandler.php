<?php

namespace App\MessageHandler\Jira;

use App\Message\Jira\TransitionMessage;
use App\MessageHandler\HandlerInterface;

class TransitionMessageHandler implements HandlerInterface
{
    public function __invoke(TransitionMessage $message)
    {
        throw new \RuntimeException($message->getIssueKey());
    }
}