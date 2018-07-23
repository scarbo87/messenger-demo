<?php

namespace App\Message\Gitlab;

use Symfony\Component\Validator\Constraints as Assert;

class MrMessage
{
    /** @var @Assert\Regex("/^issue-\d+/")*/
    private $targetBranch;
    /** @var @Assert\Regex("/^issue-\d+/")*/
    private $sourceBranch;

    public function __construct($targetBranch, $sourceBranch)
    {
        $this->targetBranch = $targetBranch;
        $this->sourceBranch = $sourceBranch;
    }

    public function getTargetBranch(): ?string
    {
        return $this->targetBranch;
    }

    public function getSourceBranch(): ?string
    {
        return $this->sourceBranch;
    }
}