<?php

namespace App\Message\Gitlab;

use Symfony\Component\Validator\Constraints as Assert;

class MrMessage
{
    /**
     * @var string
     *
     * @Assert\Regex("/^issue-\d+/")
     * @Assert\NotNull()
     */
    private $targetBranch;
    /**
     * @var string
     *
     * @Assert\Regex("/^issue-\d+/")
     * @Assert\NotNull()
     */
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