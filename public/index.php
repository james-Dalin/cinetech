<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinétech - Films & Séries</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="index.php" id="a_title"><h1 class="logo">🎬 Cinétech</h1></a>
                
                <!-- Search Bar -->
                <div class="search-container">
                    <input 
                        type="text" 
                        id="searchInput" 
                        class="search-input" 
                        placeholder="Rechercher un film ou une série..."
                    >
                    <button id="searchBtn" class="search-btn">Rechercher</button>
                </div>

                <!-- Toggle Films/Séries -->
                <div class="toggle-container">
                    <div class="user-container">
                        <button id="authBtn" class="btn btn-primary">Connexion</button>
                        <div id="userMenu" class="user-menu" style="display: none;">
                            <span id="usernameDisplay"></span>
                            <button id="logoutBtn" class="btn btn-secondary">Déconnexion</button>
                        </div>
                    </div>
                    <button class="toggle-btn active" data-type="movie">Films</button>
                    <button class="toggle-btn" data-type="tv">Séries</button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main">
        <div class="container">
            
            <!-- Movies Grid -->
            <div id="moviesGrid" class="movies-grid">
                <!-- Les films s'afficheront ici via JavaScript -->
            </div>

        </div>
    </main>

    <!-- Pagination -->
    <div class="pagination-container">
        <div class="container">
            <div class="pagination">
                <button id="prevBtn" class="pagination-btn">← Précédent</button>
                <span id="pageInfo" class="page-info">Page 1</span>
                <button id="nextBtn" class="pagination-btn">Suivant →</button>
            </div>
        </div>
    </div>

    <!-- Modal (pour détails film) -->
    <div id="movieModal" class="modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <div id="modalBody" class="modal-body">
                <!-- Détails du film s'affichent ici -->
            </div>
        </div>
    </div>

    <!-- Modal d'authentification -->
     <div id="authModal" class="modal">
        <div class="modal-content auth-modal-content">
            <span class="modal-close auth-modal-close">&times;</span>

            <!-- Formulaire de connexion -->
             <div id="loginForm">
                <h3>Connexion</h3>
                <input type="text" id="loginUsername" placeholder="Username" required>
                <input type="password" id="loginPassowrd" placeholder="Mot de passe" required>
                <button  id="loginBtn" class="btn btn-primary">Se connecter</button>
                <p>Pas de compte ? <a href="#" id="showRegister">S'enregistrer</a></p>
             </div>

             <!-- Formulaire d'Enregistrement -->
              <div id="registerForm" style="display: none;">
                <h3>S'enregistrer</h3>
                <input type="text" id="registerUsername" placeholder="Username" required>
                <input type="email" id="registerEmail" placeholder="Email" required>
                <input type="password" id="registerPassword" placeholder="Mot de passe" required>
                <button id="registerBtn" class="btn btn-primary">S'enregistrer</button>
                <p>Déjà un compte ? <a href="#" id="showLogin">Se connecter</a></p>
              </div>

              <div id="authMessage" class="auth-message"></div>
        </div>
     </div>

    <!-- Footer -->
    <footer class="footer">
        <p>Cinétech © 2025 | Données fournies par TMDB</p>
    </footer>

    <!-- Scripts -->
    <script src="js/main.js"></script>
    <script src="js/auth.js"></script>
</body>
</html>
