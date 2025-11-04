<?php

namespace App\Message;

final readonly class IndexPostMessage
{
    public function __construct(private int $postId)
    {
    }

    public function getPostId(): int
    {
        return $this->postId;
    }
}
