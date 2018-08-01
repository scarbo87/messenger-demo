<?php

namespace App\Controller;

use App\JSend\JSend;
use App\Message\Gitlab\MrMessage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
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
        try {
            $this->bus->dispatch(
                new MrMessage(
                    $request->get('targetBranch'),
                    $request->get('sourceBranch')
                )
            );
            return JSend::createSuccess('ok');
        } catch (ValidationFailedException $e) {
            return JSend::createError((string)$e->getViolations(), 400);
        } catch (\Throwable $e) {
            return JSend::createFail($e);
        }
    }
}
