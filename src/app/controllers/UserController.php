<?php
namespace App\Controllers;

use App\Models\UserModel;

class UserController{
    private $model;

    // Constructeur qui prend un modèle en paramètre
    public function __construct(UserModel $model){
        $this->model = $model;
    }

    /*
    // Méthode pour affricher un utilisateur par ID
    public function showUser($id){
        $user = $this->model->findById($id); // Récupère les données via le modèle

        include '../views/user.php'; // Passe les données à la vue pour l'affichage
    }
    */

    // Action pour afficher un utilisateur
    public function showUser($id){
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit;
        }

        $user = $this->model->findById($id); // Récupère les données via le modèle
        include 'user.php'; // Passe les données à la vue pour l'affichage
    }
}
?>