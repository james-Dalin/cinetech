/**
 * Auth.js - Gère Register, Login, Logout
 */

document.addEventListener('DOMContentLoaded', () => {
 
  // ========== DOM ELEMENTS ==========
  const authBtn = document.getElementById('authBtn');
  const authModal = document.getElementById('authModal');
  const authModalCLose = document.querySelector('.auth-modal-close');

  // Forms
  const loginForm = document.getElementById('loginForm');
  const registerForm = document.getElementById('registerFrom');
  const showRegister = document.getElementById('showRegister');
  const showLogin = document.getElementById('showLogin');

  // User menu
  const userMenu = document.getElementById('userMenu');
  const usernameDisplay = document.getElementById('usernameDisplay');
  const logoutBtn = document.getElementById('logoutBtn');

  // Messages
  const authMessage = document.getElementById('authMessage');

// ========== EVENT LISTENERS ==========

 // Ouvre le modal d'authentification
 authBtn.addEventListener('click', () => {
  authModal.classList.add('active');
  authMessage.textContent = '';
 });

 // Ferme la modal
 authModalCLose.addEventListener('click', () => {
  authModal.classList.remove('active');
 });

 authModal.addEventListener('click', (e) => {
  if (e.target === authModal) {
    authModal.classList.remove('active');
  }
 });

 // Toggle entre Login et Register
 showRegister.addEventListener('click', (e) => {
  e.preventDefault();
  loginForm.style.display = 'none';
  registerForm.style.display = 'block';
  authMessage.textContent = '';
 });

 showLogin.addEventListener('click', (e) => {
  e.preventDefault();
  registerForm.style.display = 'none';
  loginForm.style.display = 'block';
  authMessage.textContent = '';
 });

 // Logout
 logoutBtn.addEventListener('click', handleLogout);

 // ========== ACTIONS ==========

 // Register
 document.getElementById('registerBtn').addEventListener('click', async() => {
  
  const username = document.getElementById('registerUsername').value;
  const email = document.getElementById('registerEmail').value;
  const password = document.getElementById('registerPassword').value;

  if (!username || !email || !password) {
    authMessage.textContent = 'Tous les champs sont requis';
    authMessage.style.color = 'red';
    return;
  }

  const formData = new FormData();
  formData
  formData
  formData
 })
})