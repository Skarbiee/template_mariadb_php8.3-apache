<?php
header('Content-Type: application/json');
// Définit le type de contenu de la réponse en JSON, ce qui permet au client de savoir comment interpréter les données reçues.
header('Access-Control-Allow-Origin: http://localhost:8080');
// Autorise uniquement les requêtes provenant de "http://localhost:8080" (nécessaire pour le CORS).
// Si ton front-end tourne sur ce domaine et ton API sur un autre, cette ligne est indispensable pour éviter les blocages par le navigateur.
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
// Indique quelles méthodes HTTP sont autorisées pour interagir avec l'API.
// Ici, l'API accepte les requêtes de type GET (lecture), POST (ajout), PUT (modification), DELETE (suppression) et OPTIONS (pré-vérification des requêtes CORS).
header('Access-Control-Allow-Headers: Content-Type, Authorization');
// Précise quels en-têtes personnalisés peuvent être inclus dans les requêtes envoyées à l'API.
// "Content-Type" permet d'envoyer des données JSON ou d'autres formats, et "Authorization" est souvent utilisé pour les tokens d'authentification (ex: JWT).

// Importation des classe Model
require_once '../app/models/ArticleModel.php';

// On récupère l'id depuis l'url pour ensuite le convertir en entier
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

// On vérifie si un ID a été fourni
if ($id === null) {
    // On renvoi un erreur
    http_response_code(400);
    // Encoder sous JSON pour l'API
    echo json_encode(['error' => 'ID manquant']);
    // Fin du script
    exit;
}

// Si l'ID est fourni, on instancie un article
$articleModel = new ArticleModel();
// On récupère l'article correspondant à l'ID avec ses infos complètes
$article = $articleModel->getById($id);


// Si l'article existe bien
if ($article) {
    $content = $articleModel->content();
    $category = $articleModel->category();
    // On prépare la réponse en JSON
    // Instancie un tableau associatif avec le titre et le article['nomValeur']
    $reponse = [
        'id' => $id,
        'titre' => $article['title'],
        'categorie' => $category ? $category['name'] : null,
        'contenu' => $content ? $content['content'] : null,
    ];
    // Echo en json
    echo json_encode($reponse);
} else {
    // Si l'article n'existe pas, on renvoi une erreur
    http_response_code(404);
    echo json_encode(['error' => 'Article non trouvé']);
}
// Fin de script
exit;