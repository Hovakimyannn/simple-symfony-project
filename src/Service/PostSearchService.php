<?php

namespace App\Service;

use Elastica\Query;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Elastica\Aggregation\Terms as TermsAggregation;

readonly class PostSearchService
{
    public function __construct(
        private PaginatedFinderInterface $postFinder
    ) {
    }

    public function search(string $queryTerm): array
    {
        $boolQuery = new Query\BoolQuery();

        $postMatchQuery = new Query\MultiMatch();
        $postMatchQuery->setQuery($queryTerm);
        $postMatchQuery->setFields(['title^3', 'content', 'author']);
        $boolQuery->addShould($postMatchQuery);

        $commentMatchQuery = new Query\MultiMatch();
        $commentMatchQuery->setQuery($queryTerm);
        $commentMatchQuery->setFields(['comments.content', 'comments.author']);
        $nestedQuery = new Query\Nested();
        $nestedQuery->setPath('comments');
        $nestedQuery->setQuery($commentMatchQuery);
        $boolQuery->addShould($nestedQuery);
        $boolQuery->setMinimumShouldMatch(1);

        $query = new Query($boolQuery);

        $results = $this->postFinder->findPaginated($query);

        $posts = [];

        foreach ($results as $result) {
            $posts[] = $result;
        }


        return [
            'posts'   => $posts,
        ];
    }
}
