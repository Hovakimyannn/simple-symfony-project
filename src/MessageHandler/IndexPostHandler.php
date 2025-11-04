<?php

namespace App\MessageHandler;

use App\Message\IndexPostMessage;
use App\Repository\PostRepository;
use FOS\ElasticaBundle\Persister\ObjectPersisterInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class IndexPostHandler
{
    public function __construct(
        private ObjectPersisterInterface $postPersister,
        private PostRepository $postRepository
    ) {}

    public function __invoke(IndexPostMessage $message): void
    {
        $post = $this->postRepository->find($message->getPostId());

        if (!$post) {
            return;
        }

        $this->postPersister->insertOne($post);
    }
}
