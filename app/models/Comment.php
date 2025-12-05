<?php

class Comment {
    
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    /**
     * Ajoute un commentaire
     */
    public function addComment($userId, $tmdbId, $mediaType, $title, $rating, $commentText) {
        
        // Valide les données
        if (!$userId || !$tmdbId || !$mediaType || !$commentText) {
            return ['success' => false, 'error' => 'Données manquantes'];
        }

        if ($rating < 1 || $rating > 10) {
            return ['success' => false, 'error' => 'Rating entre 1 et 10'];
        }

        if (strlen($commentText) < 5) {
            return ['success' => false, 'error' => 'Commentaire min 5 caractères'];
        }

        // Insère le commentaire
        $query = "INSERT INTO comments (user_id, tmdb_id, media_type, title, rating, comment_text) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("iissss", $userId, $tmdbId, $mediaType, $title, $rating, $commentText);

        if ($stmt->execute()) {
            $commentId = $this->connection->insert_id;
            $stmt->close();

            return [
                'success' => true,
                'message' => 'Commentaire ajouté',
                'comment_id' => $commentId
            ];
        } else {
            $stmt->close();
            return ['success' => false, 'error' => 'Erreur lors de l\'ajout'];
        }
    }

    /**
     * Récupère les commentaires d'un film/série
     */
    public function getCommentsByMedia($tmdbId, $mediaType) {
        
        $query = "SELECT 
                    c.id, 
                    c.user_id, 
                    c.rating, 
                    c.comment_text, 
                    c.created_at,
                    u.username
                  FROM comments c
                  JOIN users u ON c.user_id = u.id
                  WHERE c.tmdb_id = ? AND c.media_type = ?
                  ORDER BY c.created_at DESC";

        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("is", $tmdbId, $mediaType);
        $stmt->execute();
        $result = $stmt->get_result();

        $comments = [];
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }

        $stmt->close();

        return $comments;
    }

    /**
     * Récupère les commentaires d'un utilisateur
     */
    public function getCommentsByUser($userId) {
        
        $query = "SELECT 
                    id, 
                    tmdb_id, 
                    media_type, 
                    title, 
                    rating, 
                    comment_text, 
                    created_at
                  FROM comments
                  WHERE user_id = ?
                  ORDER BY created_at DESC";

        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $comments = [];
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }

        $stmt->close();

        return $comments;
    }

    /**
     * Supprime un commentaire
     */
    public function deleteComment($commentId, $userId) {
        
        // Vérifie que le commentaire appartient à l'utilisateur
        $query = "SELECT user_id FROM comments WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $commentId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $stmt->close();
            return ['success' => false, 'error' => 'Commentaire introuvable'];
        }

        $comment = $result->fetch_assoc();
        $stmt->close();

        if ($comment['user_id'] !== $userId) {
            return ['success' => false, 'error' => 'Non autorisé'];
        }

        // Supprime le commentaire
        $query = "DELETE FROM comments WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $commentId);

        if ($stmt->execute()) {
            $stmt->close();
            return ['success' => true, 'message' => 'Commentaire supprimé'];
        } else {
            $stmt->close();
            return ['success' => false, 'error' => 'Erreur lors de la suppression'];
        }
    }

    /**
     * Met à jour un commentaire
     */
    public function updateComment($commentId, $userId, $rating, $commentText) {
        
        // Vérifie que le commentaire appartient à l'utilisateur
        $query = "SELECT user_id FROM comments WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $commentId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $stmt->close();
            return ['success' => false, 'error' => 'Commentaire introuvable'];
        }

        $comment = $result->fetch_assoc();
        $stmt->close();

        if ($comment['user_id'] !== $userId) {
            return ['success' => false, 'error' => 'Non autorisé'];
        }

        // Met à jour
        $query = "UPDATE comments SET rating = ?, comment_text = ? WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("isi", $rating, $commentText, $commentId);

        if ($stmt->execute()) {
            $stmt->close();
            return ['success' => true, 'message' => 'Commentaire mis à jour'];
        } else {
            $stmt->close();
            return ['success' => false, 'error' => 'Erreur lors de la mise à jour'];
        }
    }
}
?>
