<?php

namespace App\EventSubscriber;

use App\Entity\Comment;
use App\Entity\Post;
use App\Message\IndexPostMessage;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Messenger\MessageBusInterface;

class PostSyncSubscriber
{
    public function __construct(private MessageBusInterface $bus)
    {
    }

    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
            Events::postUpdate,
            Events::postRemove,
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->handleEvent($args);
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $this->handleEvent($args);
    }

    public function postRemove(LifecycleEventArgs $args): void
    {
        $this->handleEvent($args);
    }

    private function handleEvent(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $postId = null;

        if ($entity instanceof Post) {
            $postId = $entity->getId();
        }

        if ($entity instanceof Comment) {
            $postId = $entity->getPost()?->getId();
        }

        if ($postId !== null) {
            $message = new IndexPostMessage($postId);
            $this->bus->dispatch($message);
        }
    }
}
