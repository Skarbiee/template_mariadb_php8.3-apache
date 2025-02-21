<?php
namespace App\Controllers;

use App\Models\ArticleModel;

class ArticleController{
    private $articleModel;

    public function __construct() {
        $this->articleModel = new ArticleModel();
    }

    /**
     * Configure les en-têtes CORS pour l'API
     */
    private function setCorsHeaders() {
        // Définit le type de contenu de la réponse en JSON, ce qui permet au client de savoir comment interpréter les données reçues.
        header('Content-Type: application/json');
        // Autorise uniquement les requêtes provenant de "http://localhost:8080" (nécessaire pour le CORS).
        // Si ton front-end tourne sur ce domaine et ton API sur un autre, cette ligne est indispensable pour éviter les blocages par le navigateur.
        header('Access-Control-Allow-Origin: http://localhost:8080');
        // Indique quelles méthodes HTTP sont autorisées pour interagir avec l'API.
        // Ici, l'API accepte les requêtes de type GET (lecture), POST (ajout), PUT (modification), DELETE (suppression) et OPTIONS (pré-vérification des requêtes CORS).
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        // Précise quels en-têtes personnalisés peuvent être inclus dans les requêtes envoyées à l'API.
        // "Content-Type" permet d'envoyer des données JSON ou d'autres formats, et "Authorization" est souvent utilisé pour les tokens d'authentification (ex: JWT).
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
    }

    /**
     * Récupère un article par son ID
     */
    public function getArticle() {
        $this->setCorsHeaders();

        // Récupérer l'ID de l'article pour le convertir en INT
        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        // Vérifier si l'ID est fourni
        if($id === null){
            // On renvoie une erreur
            http_response_code(400);
            // Encoder sous JSON pour l'API
            echo json_encode(['error' => 'ID manquant']);
            // Fin du script
            exit;
        }

        // Récupérer l'article correspondant à l'ID avec ses infos complètes
        $article = $this->articleModel->getById($id);

        // Si l'article existe bien
        if ($article){
            $content = $this->articleModel->content();
            $category = $this->articleModel->category();

            // Prépare la réponse JSON
            $response = [
                'id' => $id,
                'titre' => $article['title'],
                'categorie' => $category ? $category['name'] : null,
                'contenu' => $content ? $content['content'] : null,
            ];
            
            // Echo en json
            echo json_encode($response);
        } else {
            // Si l'article n'existe pas, on renvoie une erreur
            http_response_code(404);
            echo json_encode(['error' => 'Article non trouvé']);
        }
        exit;
    }

    /**
     * Récupérer tous les articles (pour une API)
     */
    public function getAllArticles(){
        $this->setCorsHeaders();

        $articles = $this->articleModel->getAll();

        if ($articles){
            $formattedArticles = [];

            foreach ($articles as $article){
                // Récupérer le contenu et la catégorie de l'article
                $this->articleModel->id($article['id']);
                $content = $this->articleModel->content();
                $category = $this->articleModel->category();

                $formattedArticles[] = [
                    'id' => $article['id'],
                    'titre' => $article['title'],
                    'categorie' => $category ? $category['name'] : null,
                    'contenu' => $content ? $content['content'] : null,
                ];
            }

            echo json_encode($formattedArticles);
        } else {
            echo json_encode([]);
        }

        exit;
    }
    
}