/**
 * Cinétech Frontend
 * Gère l'interface et les appels API
 */

// ========== CONFIGURATION ==========

const API_BASE_URL = 'https://localhost/cinetech/public/api.php';
const TMDB_IMAGE_BASE = 'https://image.tmdb.org/t/p/w500';

// ========== STATE ==========

let currentState = {
  type: 'movie',
  currentPage: 1,
  totalPages: 1,
  searchQuery: '',
  isSearching: false
};

// ========== DOM ELEMENTS ==========

const moviesGrid = document.getElementById('moviesGrid');
const searchInput = document.getElementById('searchInput');
const searchBtn = document.getElementById('searchBtn');
const toggleBtns = document.getElementById('toggle-btn');
const prevBtn = document.getElementsById('prevBtn');
const nextBtn = document.getElementsById('nextBtn');
const pageInfo = document.getElementById('pageInfo');
const movieModal = document.getElementById('movieModal');
const modalClose = document.querySelector('.modal-close');
const modalBody = document.getElementById('modalBody');

// ========== EVENT LISTENERS ==========

//BOUTON RECHERCHE
searchBtn.addEventListener('click', handleSearch);
searchInput.addEventListener('keypress', (e) => {
  if (e.key === 'Enter') handleSearch();
});

// CHANGER FILMS/SERIES
toggleBtns.forEach(btn => {
  btn.addEventListener('click', (e) => {
    toggleBtns.forEach(b => b.classList.remove('active'));
    e.target.classList.add('active');

    currentState.type = e.target.dataset.type;
    currentState.currentPage = 1;
    currentState.isSearching = false;
    currentState.searchQuery = '';
    searchInput.value = '';

    loadMovies();
  });
});

// Pagination
prevBtn.addEventListener('click', () => {
  if (currentState.currentPage > 1) {
      currentState.currentPage--;
      loadMovies();
      window.scrollTo({ top: 0, behavior: 'smooth'});
  }
});

nextBtn.addEventListener('click', () => {
  if (currentState.currentPage < currentState.totalPages) {
      currentState.currentPage++;
      loadMovies();
      window.scrollTo({ top:0, behavior: 'smooth'});
  }
});

// Modal
modalClose.addEventListener('click', () => {
  movieModal.classList.remove('active');
});

movieModal.addEventListener('click', (e) => {
  if (e.target === movieModal) {
    movieModal.classList.remove('active');
  }
});

// ========== FUNCTIONS ==========

/**
 * Récupère les films depuis l'API
 */
async function loadMovies() {
  try {
    moviesGrid.innerHTML = '<p style="grid-column: 1/-1; text-align: center;">Chargement...</p>';
  
    let action;
    if (currentState.isSearching) {
      action = 'search';
    } else {
      action = currentState.type === 'movie' ? 'getPopularMovies' : 'getPopularSeries';
    }

    const params = new URLSearchParams({
      action: action,
      page: currentState.currentPage
    });

    if (currentState.isSearching) {
      params.append('query', currentState.searchQuery);
      params.append('type', currentState.type);
    }

    const response = await fetch(`${API_BASE_URL}?${params}`);
    const data = await response.json();

    if (!data.success || !data.data || !data.data.results) {
      moviesGrid.innerHTML = '<p style="grid-column: 1/-1; text-align: center;">Aucun résultat trouvé.</p>';
      return;
    }

    // Affiche les films
    displayMovies(data.data.results);

    // Met à jour la pagination
    currentState.totalPages = data.data.total_pages || 1;
    updatePagination();

  } catch (error) {
    console.error('Erreur:', error);
    moviesGrid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; color: red;">Erreur lors du chargement..</p>';
  }
}

/**
 * Affiche les films dans la grille
 */
function displayMovies(movies) {
  
}