<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  
  <!-- HEADER -->
   <header class="header">
    <div class="container">
      <div class="header-content">
        <h1 class="logo">🎬 Cinétech</h1>

  <!-- BARRE DE RECHERCHE -->
   <div class="search-container">
    <input 
    type="text"
    id="searchInput"
    class="search-input"
    placeholder="Rechercher un film ou une série...">
    <button id="searchBtn" class="search-btn">Rechercher</button>
   </div>

   <!-- Toggle FILMS/SÉRIES -->
    <div class="toggle-container">
      <button class="toggle-btn active" data-type="movie">Films</button>
      <button class="toggle-btn" data-type="tv">Séries</button>
    </div>
      </div>
    </div>
   </header>

   <!-- CONTENU PRINCIPAL -->
    <main class="main">
      <div class="container">

      <!-- GRILLE DES FILMS -->
       <div id="moviesGrid" class="movies-grid">
        <!-- Les films s'afficheront ici via JS -->
       </div>
      </div>
    </main>

    <!-- PAGINATION -->
     <div class="pagination-container">
      <div class="container">
        <div class="pagination">
          <button id="prevBtn" class="pagination-btn"><- Pécédent</button>
          <span id="pageInfo" class="page-info">Page 1</span>
          <button id="nextBtn" class="pagination-btn">Suivant -></button>
        </div>
      </div>
     </div>

     <!-- Model (pour détails film) -->
      <div id="movieModal" class="modal">
        <div class="modal-content">
          <span class="modal-close">&times;</span>
          <div id="modalBody" class="modal-body">
            <!-- Détails du film s'affichent ici -->
          </div>
        </div>
      </div>

      <!-- FOOTER -->
       <footer class="footer">
        <p>Cinétech @ 2025 | Données fournies par TMDB</p>
       </footer>

       <script src="js/main.js"></script>
</body>
</html>