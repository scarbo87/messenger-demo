<?php

namespace App\Controller;

use App\EnvelopeItem\AuditItem;
use App\JSend\JSend;
use App\Message\Gitlab\MrMessage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class GitlabController extends Controller
{
    private $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function mr(Request $request): JsonResponse
    {
        $this->bus->dispatch(
            new MrMessage(
                $request->get('id'),
                $request->get('targetBranch'),
                $request->get('sourceBranch')
            )
        );

        return JSend::createSuccess($request->get('id'));
    }
}
