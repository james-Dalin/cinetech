<?php

declare(strict_types = 1);

class User {
    
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    /**
     * Crée un nouvel utilisateur (Register)
     */
    public function register($username, $email, $password) {
        
        // Valide les données
        if (strlen($username) < 3 || strlen($username) > 50) {
            return ['success' => false, 'error' => 'Username entre 3 et 50 caractères'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'error' => 'Email invalide'];
        }

        if (strlen($password) < 6) {
            return ['success' => false, 'error' => 'Mot de passe min 6 caractères'];
        }

        // Vérifie que l'utilisateur n'existe pas
        $query = "SELECT id FROM users WHERE username = ? OR email = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return ['success' => false, 'error' => 'Username ou email déjà utilisé'];
        }

        $stmt->close();

        // Hash le mot de passe
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // Insère l'utilisateur
        $query = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("sss", $username, $email, $passwordHash);

        if ($stmt->execute()) {
            $userId = $this->connection->insert_id;
            $stmt->close();

            return [
                'success' => true,
                'message' => 'Utilisateur créé avec succès',
                'user_id' => $userId
            ];
        } else {
            $stmt->close();
            return ['success' => false, 'error' => 'Erreur lors de la création'];
        }
    }

    /**
     * Authentifie un utilisateur (Login)
     */
    public function login($username, $password) {
        
        // Vérifie les données
        if (empty($username) || empty($password)) {
            return ['success' => false, 'error' => 'Username et mot de passe requis'];
        }

        // Récupère l'utilisateur
        $query = "SELECT id, username, email, password_hash FROM users WHERE username = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $stmt->close();
            return ['success' => false, 'error' => 'Username ou mot de passe incorrect'];
        }

        $user = $result->fetch_assoc();
        $stmt->close();

        // Vérifie le mot de passe
        if (!password_verify($password, $user['password_hash'])) {
            return ['success' => false, 'error' => 'Username ou mot de passe incorrect'];
        }

        // Crée une session
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];

        return [
            'success' => true,
            'message' => 'Connecté avec succès',
            'user' => [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email']
            ]
        ];
    }

    /**
     * Récupère un utilisateur par ID
     */
    public function getUserById($userId) {
        $query = "SELECT id, username, email, created_at FROM users WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $stmt->close();
            return false;
        }

        $user = $result->fetch_assoc();
        $stmt->close();

        return $user;
    }

    /**
     * Logout
     */
    public function logout() {
        session_start();
        session_destroy();
        return ['success' => true, 'message' => 'Déconnecté'];
    }

    /**
     * Vérifie si un utilisateur est connecté
     */
    public function isLoggedIn() {
        session_start();
        return isset($_SESSION['user_id']);
    }

    /**
     * Récupère l'utilisateur actuellement connecté
     */
    public function getCurrentUser() {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            return false;
        }

        return [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'email' => $_SESSION['email']
        ];
    }
}
?>
