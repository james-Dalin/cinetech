<?php 

declare(strict_types = 1);

class Series {

  private $tmdbClient;

  public function __construct($tmdbClient) {
    $this->tmdbClient = $tmdbClient;
  }

  public function getPopularSeries($page = 1) {
    $tmdbData = $this->tmdbClient->getPopularSeries($page);

    if ($tmdbData === false || !isset($tmdbData['results'])) {
      return false;
    }

    return [
      'results' => $tmdbData['results'],
      'total_pages' => $tmdbData['total_pages'] ?? 0,
      'page' => $tmdbData['page'] ?? $page
    ];
  }

  public function getSeriesDetail($seriesId) {
    $series = $this->tmdbClient->getSeriesDetail($seriesId);

    if ($series === false) {
      return false;
    }

    return $series;
  }

  public function search($query, $page = 1) {
    $query = trim($query);
    if (strlen($query) < 2) {
      return false;
    }

    $results = $this->tmdbClient->search($query, 'tv', $page);

    if ($results === false || !isset($results['results'])) {
        return false;
    }

    return [
      'results' => $results['results'],
      'total_pages' => $results['total_pages'] ?? 0,
      'page' => $results['page'] ?? 0
    ];
  }

  public function getSimilarSeries($seriesId, $page = 1) {
    $similar = $this->tmdbClient->getSimilarSeries($seriesId, $page);

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