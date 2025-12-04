<?php

declare(strict_types = 1);

class TmdbApiClient {
    
    private $apiKey;
    private $baseUrl = 'https://api.themoviedb.org/3';
    private $language = 'fr-FR';

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    private function makeRequest($endpoint, $params = []) {
        
        $defaultParams = [
            'api_key' => $this->apiKey,
            'language' => $this->language
        ];
        
        $allParams = array_merge($defaultParams, $params);
        $queryString = http_build_query($allParams);
        $url = $this->baseUrl . $endpoint . '?' . $queryString;

        $response = file_get_contents($url);

        if ($response === false) {
            return false;
        }

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        return $data;
    }

    public function getPopularMovies($page = 1) {
        return $this->makeRequest('/movie/popular', [
            'page' => (int)$page
        ]);
    }

    public function getPopularSeries($page = 1) {
        return $this->makeRequest('/tv/popular', [
            'page' => (int)$page
        ]);
    }

    public function getMovieDetail($movieId) {
        $appendParams = ['credits', 'recommendations', 'images'];
        
        return $this->makeRequest('/movie/' . (int)$movieId, [
            'append_to_response' => implode(',', $appendParams)
        ]);
    }

    public function getSeriesDetail($seriesId) {
        $appendParams = ['credits', 'recommendations', 'images'];
        
        return $this->makeRequest('/tv/' . (int)$seriesId, [
            'append_to_response' => implode(',', $appendParams)
        ]);
    }

    public function search($query, $type = 'multi', $page = 1) {
        $validTypes = ['movie', 'tv', 'multi'];
        if (!in_array($type, $validTypes)) {
            $type = 'multi';
        }

        return $this->makeRequest('/search/' . $type, [
            'query' => $query,
            'page' => (int)$page
        ]);
    }

    public function getSimilarMovies($movieId, $page = 1) {
        return $this->makeRequest('/movie/' . (int)$movieId . '/similar', [
            'page' => (int)$page
        ]);
    }

    public function getSimilarSeries($seriesId, $page = 1) {
        return $this->makeRequest('/tv/' . (int)$seriesId . '/similar', [
            'page' => (int)$page
        ]);
    }
}
?>
