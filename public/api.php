<?php

// ========== CORS HEADERS ==========
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8');

// Gère les requêtes OPTIONS (préflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// ========== RESTE DU CODE ==========

try {
    
    require_once __DIR__ . '/../app/config/tmdb.php';
    require_once __DIR__ . '/../app/config/Database.php';
    require_once __DIR__ . '/../app/models/TmdbApiClient.php';
    require_once __DIR__ . '/../app/models/Movie.php';
    require_once __DIR__ . '/../app/models/Series.php';
    require_once __DIR__ . '/../app/controllers/MovieController.php';
    require_once __DIR__ . '/../app/controllers/SeriesController.php';

    $database = new Database();
    $connection = $database->getConnection();

    $tmdbClient = new TmdbApiClient(TMDB_API_KEY);
    $movieModel = new Movie($tmdbClient);
    $seriesModel = new Series($tmdbClient);
    $movieController = new MovieController($movieModel);
    $seriesController = new SeriesController($seriesModel);

    $action = isset($_GET['action']) ? $_GET['action'] : '';

    $response = [
        'success' => false,
        'error' => 'Action inconnue'
    ];

    switch ($action) {
        // Movies
        case 'getPopularMovies':
            $response = $movieController->getPopularMovies();
            break;

        case 'getMovieDetail':
            $response = $movieController->getMovieDetail();
            break;

        case 'getSimilarMovies':
            $response = $movieController->getSimilarMovies();
            break;

        // Series
        case 'getPopularSeries':
            $response = $seriesController->getPopularSeries();
            break;

        case 'getSeriesDetail':
            $response = $seriesController->getSeriesDetail();
            break;

        case 'getSimilarSeries':
            $response = $seriesController->getSimilarSeries();
            break;

        default:
            http_response_code(400);
            $response = [
                'success' => false,
                'error' => 'Action inconnue: ' . htmlspecialchars($action)
            ];
    }

    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Exception: ' . $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

exit;
?>
