<?php

namespace App\Controller;

use App\Service\PostSearchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function search(Request $request, PostSearchService $searchService): Response
    {
        $query = $request->query->get('q', '');
        $posts = [];

        if (!empty($query)) {
            $results = $searchService->search($query);
            $posts = $results['posts'];
        }

        return $this->render('search/results.html.twig', [
            'query'   => $query,
            'posts'   => $posts,
        ]);
    }
}
