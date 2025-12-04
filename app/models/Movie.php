<?php

declare(strict_types = 1);

class Movie {
    
    private $tmdbClient;

    public function __construct($tmdbClient) {
        $this->tmdbClient = $tmdbClient;
    }

    public function getPopularMovies($page = 1) {
        $tmdbData = $this->tmdbClient->getPopularMovies($page);

        if ($tmdbData === false || !isset($tmdbData['results'])) {
            return false;
        }

        return [
            'results' => $tmdbData['results'],
            'total_pages' => $tmdbData['total_pages'] ?? 0,
            'page' => $tmdbData['page'] ?? $page
        ];
    }

    public function getMovieDetail($movieId) {
        $movie = $this->tmdbClient->getMovieDetail($movieId);

        if ($movie === false) {
            return false;
        }

        return $movie;
    }

    public function search($query, $page = 1) {
        $query = trim($query);
        if (strlen($query) < 2) {
            return false;
        }

        $results = $this->tmdbClient->search($query, 'movie', $page);

        if ($results === false || !isset($results['results'])) {
            return false;
        }

        return [
            'results' => $results['results'],
            'total_pages' => $results['total_pages'] ?? 0,
            'page' => $results['page'] ?? $page
        ];
    }

    public function getSimilarMovies($movieId, $page = 1) {
        $similar = $this->tmdbClient->getSimilarMovies($movieId, $page);

        if ($similar === false || !isset($similar['results'])) {
            return false;
        }

        return [
            'results' => $similar['results'],
            'total_pages' => $similar['total_pages'] ?? 0
        ];
    }
}
?>
