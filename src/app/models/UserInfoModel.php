<?php
class UserInfoModel extends Model{
    protected $table = 'users_infos'; // nom de la table

    // Constructeur : appel au constructeur parent pour la connexion
    public function __construct(){
        parent::__construct($this->table);
    }
    
    // Méthode pour récupérer les informations d'un utilisateur par son ID
    public function findByUserId($userId){
        return $this->select('*') // Sélectionne toutes les colonnes
            ->where('user_id', '=', $userId) // Condition WHERE user_id = ?
            ->get(); // Exécute la requête et retourne le résultat
    }
}
?>