<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\Comment;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $post = new Post();
            $post->setTitle('Post Title ' . $i);
            $post->setContent('This is the content for post number ' . $i);
            $post->setCreatedAt(new DateTime());
            $manager->persist($post);

            for ($j = 1; $j <= 2; $j++) {
                $comment = new Comment();
                $comment->setAuthor('Visitor ' . $j);
                $comment->setContent('This is a great comment on post ' . $i);
                $comment->setCreatedAt(new DateTime());
                $comment->setPost($post);
                $manager->persist($comment);
            }
        }

        $manager->flush();
    }
}
