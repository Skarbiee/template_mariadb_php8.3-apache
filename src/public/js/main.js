// Logging pour le débogage
console.log("main.js chargé");
// Attente du chargement complet du DOM avant d'initialiser les fonctionnalités
document.addEventListener('DOMContentLoaded', function () {
    console.log("DOM chargé");
    // Vérification de la présence des éléments clés dans le DOM
    console.log("Modal element:", document.getElementById('articleModal'));
    console.log("Tous les boutons:", document.querySelectorAll('.btn-view'));
});

// Fonction qui récupère les données d'un article via une requête AJAX
// @param {number} id - L'identifiant de l'article à récupérer
function fetchData(id) {
    console.log("Fetching data for id:", id);
    let xhr = new XMLHttpRequest();
    // Configuration de la requête GET vers l'API
    xhr.open("GET", "/api/article?id=" + id, true);

    // Gestion des changements d'état de la requête
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) { // 4 = requête terminée
            console.log("ReadyState:", xhr.readyState);
            console.log("Status:", xhr.status);
            console.log("Response:", xhr.responseText); // Afficher la réponse brute

            if (xhr.status === 200) { // 200 = succès
                try {
                    // Conversion de la réponse JSON en objet JavaScript
                    let response = JSON.parse(xhr.responseText);
                    console.log("Données reçues:", response);
                    // Affichage des données dans la modal
                    showModal(response.title, response.content);
                } catch (e) {
                    console.error("Erreur parsing JSON:", e);
                console.error("Texte reçu:", xhr.responseText);
                    // Gestion des erreurs de parsing JSON
                    console.error("Erreur parsing:", e);
                }
            }
        }
    };
    // Envoi de la requête
    xhr.send();
}

// Fonction d'affichage de la modal avec le contenu de l'article
// @param {string} title - Le titre de l'article
// @param {string} content - Le contenu de l'article
function showModal(title, content) {
    console.log("Showing modal with:", { title, content });

    // Récupération des éléments DOM de la modal
    const modal = document.getElementById('articleModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalContent = document.getElementById('modalContent');

    // Injection du contenu dans la modal
    modalTitle.textContent = title;
    modalContent.textContent = content;
    // Affichage de la modal
    modal.style.display = 'block';

    // Configuration du bouton de fermeture
    const closeBtn = modal.querySelector('.modal-close');
    closeBtn.onclick = closeModal;

    // Fermeture de la modal en cliquant en dehors
    modal.onclick = function (event) {
        if (event.target === modal) {
            closeModal();
        }
    };
}

// Fonction de fermeture de la modal
function closeModal() {
    console.log("Closing modal");
    const modal = document.getElementById('articleModal');
    modal.style.display = 'none';
}

// Configuration de la fermeture de la modal avec la touche Escape
document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});