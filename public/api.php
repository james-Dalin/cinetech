<?php

// ========== START SESSION ==========
session_start();

// ========== CORS HEADERS ==========
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

try {
    
    // ========== CONFIGS ==========
    require_once __DIR__ . '/../app/config/tmdb.php';
    require_once __DIR__ . '/../app/config/Database.php';

    // ========== MODELS ==========
    require_once __DIR__ . '/../app/models/TmdbApiClient.php';
    require_once __DIR__ . '/../app/models/Movie.php';
    require_once __DIR__ . '/../app/models/Series.php';
    require_once __DIR__ . '/../app/models/User.php';
    require_once __DIR__ . '/../app/models/Comment.php';

    // ========== CONTROLLERS ==========
    require_once __DIR__ . '/../app/controllers/MovieController.php';
    require_once __DIR__ . '/../app/controllers/SeriesController.php';
    require_once __DIR__ . '/../app/controllers/AuthController.php';
    require_once __DIR__ . '/../app/controllers/CommentController.php';

    // ========== INITIALIZATION ==========

    $database = new Database();
    $connection = $database->getConnection();

    $tmdbClient = new TmdbApiClient(TMDB_API_KEY);

    // Models
    $movieModel = new Movie($tmdbClient);
    $seriesModel = new Series($tmdbClient);
    $userModel = new User($connection);
    $commentModel = new Comment($connection);

    // Controllers
    $movieController = new MovieController($movieModel);
    $seriesController = new SeriesController($seriesModel);
    $authController = new AuthController($userModel);
    $commentController = new CommentController($commentModel);

    // ========== ROUTER ==========

    $action = isset($_GET['action']) ? $_GET['action'] : '';

    $response = [
        'success' => false,
        'error' => 'Action inconnue'
    ];

    switch ($action) {

        // ========== MOVIES ==========
        case 'getPopularMovies':
            $response = $movieController->getPopularMovies();
            break;

        case 'getMovieDetail':
            $response = $movieController->getMovieDetail();
            break;

        case 'getSimilarMovies':
            $response = $movieController->getSimilarMovies();
            break;

        // ========== SERIES ==========
        case 'getPopularSeries':
            $response = $seriesController->getPopularSeries();
            break;

        case 'getSeriesDetail':
            $response = $seriesController->getSeriesDetail();
            break;

        case 'getSimilarSeries':
            $response = $seriesController->getSimilarSeries();
            break;

        // ========== SEARCH ==========
        case 'search':
            $query = isset($_GET['query']) ? $_GET['query'] : '';
            $type = isset($_GET['type']) ? $_GET['type'] : 'multi';
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

            if (strlen($query) < 2) {
                $response = [
                    'success' => false,
                    'error' => 'Recherche trop courte'
                ];
                break;
            }

            if ($type === 'tv') {
                $result = $seriesModel->search($query, $page);
            } else {
                $result = $movieModel->search($query, $page);
            }

            $response = [
                'success' => $result !== false,
                'data' => $result
            ];
            break;

        // ========== AUTH ==========
        case 'register':
            $response = $authController->register();
            break;

        case 'login':
            $response = $authController->login();
            break;

        case 'logout':
            $response = $authController->logout();
            break;

        case 'isLoggedIn':
            $response = $authController->isLoggedIn();
            break;

        case 'getCurrentUser':
            $response = $authController->getCurrentUser();
            break;

        // ========== COMMENTS ==========
        case 'addComment':
            $response = $commentController->addComment();
            break;

        case 'getComments':
            $response = $commentController->getComments();
            break;

        case 'deleteComment':
            $response = $commentController->deleteComment();
            break;

        // ========== DEFAULT ==========
        default:
            http_response_code(400);
            $response = [
                'success' => false,
                'error' => 'Action inconnue: ' . htmlspecialchars($action)
            ];
    }

    // ========== RESPONSE ==========

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
