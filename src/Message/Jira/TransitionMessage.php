<?php

namespace App\Message\Jira;

use Symfony\Component\Validator\Constraints as Assert;

class TransitionMessage
{
    /**
     * @var string
     *
     * @Assert\Regex("/^issue-\d+/")
     * @Assert\NotNull()
     */
    private $issueKey;
    private $transitionId;
    private $comment;

    // для null-абле полей обязательно указывать ?TYPE, иначе нормалайзер ругнется TypeError
    public function __construct(int $transitionId, string $issueKey, ?string $comment = null)
    {
        $this->transitionId = $transitionId;
        $this->issueKey = $issueKey;
        $this->comment = $comment;
    }

    public function getIssueKey(): string
    {
        return $this->issueKey;
    }

    public function getTransitionId(): int
    {
        return $this->transitionId;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }
}
