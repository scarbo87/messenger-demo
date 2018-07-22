<?php

namespace App\Message\Gitlab;

use Symfony\Component\Validator\Constraints as Assert;

class MrMessage
{
    private $id;
    /** @var @Assert\Regex("/^issue-\d+/")*/
    private $targetBranch;
    /** @var @Assert\Regex("/^issue-\d+/")*/
    private $sourceBranch;

    public function __construct(int $id, string $targetBranch, string $sourceBranch)
    {
        $this->id = $id;
        $this->targetBranch = $targetBranch;
        $this->sourceBranch = $sourceBranch;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTargetBranch(): string
    {
        return $this->targetBranch;
    }

    public function getSourceBranch(): string
    {
        return $this->sourceBranch;
    }
}