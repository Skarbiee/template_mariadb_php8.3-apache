<?php

// Importation des classe ArticleModel
use App\Models\ArticleModel;


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