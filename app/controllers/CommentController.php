<?php

class CommentController {
    
    private $commentModel;

    public function __construct($commentModel) {
        $this->commentModel = $commentModel;
    }

    /**
     * Ajoute un commentaire
     */
    public function addComment() {
        // Vérifie que l'utilisateur est connecté
        session_start();
        if (!isset($_SESSION['user_id'])) {
            return [
                'success' => false,
                'error' => 'Non connecté'
            ];
        }

        $userId = $_SESSION['user_id'];
        $tmdbId = isset($_POST['tmdbId']) ? (int)$_POST['tmdbId'] : null;
        $mediaType = isset($_POST['mediaType']) ? $_POST['mediaType'] : null;
        $title = isset($_POST['title']) ? $_POST['title'] : null;
        $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : null;
        $commentText = isset($_POST['comment']) ? $_POST['comment'] : null;

        $result = $this->commentModel->addComment($userId, $tmdbId, $mediaType, $title, $rating, $commentText);
        return $result;
    }

    /**
     * Récupère les commentaires d'un film/série
     */
    public function getComments() {
        $tmdbId = isset($_GET['tmdbId']) ? (int)$_GET['tmdbId'] : null;
        $mediaType = isset($_GET['mediaType']) ? $_GET['mediaType'] : null;

        if (!$tmdbId || !$mediaType) {
            return [
                'success' => false,
                'error' => 'tmdbId et mediaType requis'
            ];
        }

        $comments = $this->commentModel->getCommentsByMedia($tmdbId, $mediaType);

        return [
            'success' => true,
            'data' => $comments
        ];
    }

    /**
     * Supprime un commentaire
     */
    public function deleteComment() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            return [
                'success' => false,
                'error' => 'Non connecté'
            ];
        }

        $userId = $_SESSION['user_id'];
        $commentId = isset($_POST['commentId']) ? (int)$_POST['commentId'] : null;

        if (!$commentId) {
            return [
                'success' => false,
                'error' => 'commentId requis'
            ];
        }

        $result = $this->commentModel->deleteComment($commentId, $userId);
        return $result;
    }
}
?>
