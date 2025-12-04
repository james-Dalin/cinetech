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

const moviesGird = document.getElementById('moviesGrid');
const searchInput = document.getElementById('searchInput');
const searchBtn = document.getElementById('searchBtn');
const toggleBtn = document.getElementById('toggle-btn');
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

    currentState.type = e.target.datatest.type;
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
modalClose.addEventListener('click', (e) => {
  if (e.target === movieModal) {
    movieModal.classList.remove('active');
  }
});