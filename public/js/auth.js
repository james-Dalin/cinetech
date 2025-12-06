/**
 * Auth.js - Gère Register, Login, Logout
 */

// Utilise API_BASE_URL défini dans main.js

document.addEventListener('DOMContentLoaded', () => {

    // ========== DOM ELEMENTS ==========
    const authBtn = document.getElementById('authBtn');
    const authModal = document.getElementById('authModal');
    const authModalClose = document.querySelector('.auth-modal-close');
    
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const showRegister = document.getElementById('showRegister');
    const showLogin = document.getElementById('showLogin');

    const userMenu = document.getElementById('userMenu');
    const usernameDisplay = document.getElementById('usernameDisplay');
    const logoutBtn = document.getElementById('logoutBtn');
    
    const authMessage = document.getElementById('authMessage');
    const loginBtn = document.getElementById('loginBtn');
    const registerBtn = document.getElementById('registerBtn');

    const loginUsername = document.getElementById('loginUsername');
    const loginPassword = document.getElementById('loginPassword');
    const registerUsername = document.getElementById('registerUsername');
    const registerEmail = document.getElementById('registerEmail');
    const registerPassword = document.getElementById('registerPassword');

    // ========== ERROR CHECK ==========
    if (!authBtn || !authModal) {
        console.error('Éléments HTML manquants');
        return;
    }

    // ========== EVENT LISTENERS ==========

    authBtn.addEventListener('click', () => {
        authModal.classList.add('active');
        authMessage.textContent = '';
    });

    if (authModalClose) {
        authModalClose.addEventListener('click', () => {
            authModal.classList.remove('active');
        });
    }

    authModal.addEventListener('click', (e) => {
        if (e.target === authModal) {
            authModal.classList.remove('active');
        }
    });

    if (showRegister) {
        showRegister.addEventListener('click', (e) => {
            e.preventDefault();
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
            authMessage.textContent = '';
        });
    }

    if (showLogin) {
        showLogin.addEventListener('click', (e) => {
            e.preventDefault();
            registerForm.style.display = 'none';
            loginForm.style.display = 'block';
            authMessage.textContent = '';
        });
    }

    // ========== REGISTER ==========
    if (registerBtn) {
        registerBtn.addEventListener('click', async () => {
            const username = registerUsername.value.trim();
            const email = registerEmail.value.trim();
            const password = registerPassword.value;

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
                    authMessage.textContent = 'Enregistrement réussi! Veuillez vous connecter.';
                    authMessage.style.color = 'green';
                    registerUsername.value = '';
                    registerEmail.value = '';
                    registerPassword.value = '';
                    
                    setTimeout(() => {
                        if (showLogin) showLogin.click();
                    }, 1500);
                } else {
                    authMessage.textContent = data.error || 'Erreur lors de l\'enregistrement';
                    authMessage.style.color = 'red';
                }
            } catch (error) {
                console.error('Erreur Register:', error);
                authMessage.textContent = 'Erreur réseau: ' + error.message;
                authMessage.style.color = 'red';
            }
        });
    }

    // ========== LOGIN ==========
    if (loginBtn) {
        loginBtn.addEventListener('click', async () => {
            const username = loginUsername.value.trim();
            const password = loginPassword.value;

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
                    authModal.classList.remove('active');
                    loginUsername.value = '';
                    loginPassword.value = '';
                    updateUserUI(data.user.username);
                } else {
                    authMessage.textContent = data.error || 'Erreur lors de la connexion';
                    authMessage.style.color = 'red';
                }
            } catch (error) {
                console.error('Erreur Login:', error);
                authMessage.textContent = 'Erreur réseau: ' + error.message;
                authMessage.style.color = 'red';
            }
        });
    }

    // ========== LOGOUT ==========
    if (logoutBtn) {
        logoutBtn.addEventListener('click', async () => {
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
        });
    }

    // ========== UI UPDATE ==========
    function updateUserUI(username) {
        if (username) {
            authBtn.style.display = 'none';
            userMenu.style.display = 'flex';
            usernameDisplay.textContent = `Bonjour, ${username}`;
        } else {
            authBtn.style.display = 'block';
            userMenu.style.display = 'none';
            usernameDisplay.textContent = '';
        }
    }

    // ========== CHECK LOGIN ON LOAD ==========
    async function checkLoginStatus() {
        try {
            const response = await fetch(`${API_BASE_URL}?action=getCurrentUser`);
            
            if (!response.ok) {
                console.error('HTTP Error:', response.status);
                updateUserUI(null);
                return;
            }

            const data = await response.json();

            if (data.success && data.user) {
                updateUserUI(data.user.username);
            } else {
                updateUserUI(null);
            }
        } catch (error) {
            console.error('Erreur checkLoginStatus:', error);
            updateUserUI(null);
        }
    }

    checkLoginStatus();
});
