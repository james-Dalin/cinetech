<?php

declare(strict_types = 1);

class SeriesController {
    
    private $seriesModel;

    public function __construct($seriesModel) {
        $this->seriesModel = $seriesModel;
    }

    public function getPopularSeries() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        if ($page < 1) {
            $page = 1;
        }

        $series = $this->seriesModel->getPopularSeries($page);

        return [
            'success' => $series !== false,
            'data' => $series
        ];
    }

    public function getSeriesDetail() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if (!$id || $id <= 0) {
            return [
                'success' => false,
                'error' => 'ID invalide'
            ];
        }

        $series = $this->seriesModel->getSeriesDetail($id);

        return [
            'success' => $series !== false,
            'data' => $series
        ];
    }

    public function getSimilarSeries() {
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

        $similar = $this->seriesModel->getSimilarSeries($id, $page);

        return [
            'success' => $similar !== false,
            'data' => $similar
        ];
    }
}
?>
