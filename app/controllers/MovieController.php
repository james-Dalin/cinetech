<?php

declare(strict_types = 1);

class MovieController {
    
    private $movieModel;

    public function __construct($movieModel) {
        $this->movieModel = $movieModel;
    }

    public function getPopularMovies() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        if ($page < 1) {
            $page = 1;
        }

        $movies = $this->movieModel->getPopularMovies($page);

        return [
            'success' => $movies !== false,
            'data' => $movies
        ];
    }

    public function getMovieDetail() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if (!$id || $id <= 0) {
            return [
                'success' => false,
                'error' => 'ID invalide'
            ];
        }

        $movie = $this->movieModel->getMovieDetail($id);

        return [
            'success' => $movie !== false,
            'data' => $movie
        ];
    }

    public function getSimilarMovies() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        if (!$id || $id <= 0) {
            return [
                'success' => false,
                'error' => 'ID invalide'
            ];
        }

        if ($page < 1) {
            $page = 1;
        }

        $similar = $this->movieModel->getSimilarMovies($id, $page);

        return [
            'success' => $similar !== false,
            'data' => $similar
        ];
    }
}
?>
