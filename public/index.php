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

    <!-- Footer -->
    <footer class="footer">
        <p>Cinétech © 2025 | Données fournies par TMDB</p>
    </footer>

    <!-- Scripts -->
    <script src="js/main.js"></script>
</body>
</html>
