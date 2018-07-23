<?php

namespace App\MessageHandler\Jira;

use App\Message\Jira\TransitionMessage;
use App\MessageHandler\HandlerInterface;

class TransitionMessageHandler implements HandlerInterface
{
    public function __invoke(TransitionMessage $message)
    {
        dump('TransitionMessageHandler: sleeping 1 sec ...');
        sleep(1);
        dump($message);
    }
}