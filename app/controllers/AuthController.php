<?php

class AuthController {
    
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    /**
     * Register - Crée un nouvel utilisateur
     */
    public function register() {
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;

        if (!$username || !$email || !$password) {
            return [
                'success' => false,
                'error' => 'Username, email et mot de passe requis'
            ];
        }

        $result = $this->userModel->register($username, $email, $password);
        return $result;
    }

    /**
     * Login - Authentifie un utilisateur
     */
    public function login() {
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;

        if (!$username || !$password) {
            return [
                'success' => false,
                'error' => 'Username et mot de passe requis'
            ];
        }

        $result = $this->userModel->login($username, $password);
        return $result;
    }

    /**
     * Logout - Déconnecte l'utilisateur
     */
    public function logout() {
        return $this->userModel->logout();
    }

    /**
     * isLoggedIn - Vérifie si connecté
     */
    public function isLoggedIn() {
        $isLoggedIn = $this->userModel->isLoggedIn();
        return [
            'success' => true,
            'isLoggedIn' => $isLoggedIn
        ];
    }

    /**
     * getCurrentUser - Récupère l'utilisateur connecté
     */
    public function getCurrentUser() {
        $user = $this->userModel->getCurrentUser();
        
        if (!$user) {
            return [
                'success' => false,
                'error' => 'Non connecté'
            ];
        }

        return [
            'success' => true,
            'user' => $user
        ];
    }
}
?>
