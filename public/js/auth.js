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
 document.getElementById('registerBtn').addEventListener('click', async () => {
  
  const username = document.getElementById('registerUsername').value;
  const email = document.getElementById('registerEmail').value;
  const password = document.getElementById('registerPassword').value;

  if (!username || !email || !password) {
    authMessage.textContent = 'Tous les champs sont requis';
    authMessage.style.color = 'red';
    return;
  }

  const formData = new FormData();
  formData.append('username', username);
  formData.append('email', email);
  formData.append('password', password);

  try {
    const response = await fetch(`${API_BASE_URL}?action=register`, {
      method: 'POST',
      body: formData
    });

    const data = await response.json();

    if (data.success) {
      authMessage.textContent = 'Enregistrement réussi ! Veuillez vous connecter.';
      authMessage.style.color = 'green';
      showLogin().click(); // Change vers le login
    } else {
      authMessage.textContent = data.error || 'Erreur lors de l\'enregistrement';
      authMessage.style.color = 'red';
    }
  } catch (error) {
    console.error('Erreur Register:', error);
    authMessage.textContent = 'Erreur réseau';
    authMessage.style.color = 'red';
  }
 });

 // login
 document.getElementById('loginBtn').addEventListener('click', async () => {
  
  const username = document.getElementById('loginUsername').value;
  const password = document.getElementById('loginPassword').value;

  if (!username || !password) {
    authMessage.textContent = 'Username et mot de passe requis';
    authMessage.style.color = 'red';
    return;
  }

  const formData = new FormData();
  formData.append('username', username);
  formData.append('password', password);

  try {
    const response = await fetch(`${API_BASE_URL}?action=login`, {
      method: 'POST',
      body: formData
    });

    const data = await response.json();

    if (data.success) {
      authMessage.classList.remove('active');
      updateUserUI(data.user.username);
    } else {
      authMessage.textContent = data.error || 'Erreur lors de la connexion';
      authMessage.style.color = 'red';
    }
  } catch (error) {
    console.error('Erreur login:', error);
    authMessage.textContent = 'Erreur réseau';
    authMessage.style.color = 'red';
  }
 });

 // Déconnexion
 async function handleLogout() {
  try {
    const response = await fetch(`${API_BASE_URL}?action=logout`, {
      method: 'POST'
    });

    const data = await response.json();

    if (data.success) {
      updateUserUI(null);
    }
  } catch (error) {
    console.error('Erreur Logout:', error);
  }
 }

    // ========== UI UPDATE ==========

    function updateUserUI(username) {
      if (username) {
        authBtn.style.display = 'none';
        userMenu.style.display = 'flex';
        usernameDisplay.textContent = `Bonjour, ${username}`;
      } else {
        authBtn.style.display = 'none';
        userMenu.style.display = 'none';
        usernameDisplay.textContent = '';
      }
    }

    // ========== CHECK LOGIN ON LOAD ==========
    async function checkLoginStatus() {
      try {
        const response = await fetch(`${API_BASE_URL}?action=getCurrentUser`);
        const data = await response.json();

        if (data.success && data.user) {
          updateUserUI(data.user.username);
        } else {
          updateUserUI(null);
        }
      } catch (error) {
        console.error('Erreur checkLoginStatus', error)
      }
    }

    checkLoginStatus();
});