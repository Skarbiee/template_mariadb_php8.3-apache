<?php
class UserModel extends Model
{
    protected $table = 'users'; // nom de la table
    
    // Constructeur : appel au constructeur parent pour la connexion
    public function __construct(){
        parent::__construct($this->table);
    }

    // Méthode pour récupérer un utilisateur par son ID
    public function findById($id){
        return $this->select('*') // Sélectionne toutes les colonnes
            ->where('id', '=', $id) // Condition WHERE id = ?
            ->get(); // Exécute la requête et retourne le résultat
    }

    // Méthode pour supprimer un utilisateur
    public function deleteById($id){
        $this->query = "DELETE FROM " . $this->table . " WHERE id = :id";   // Construction de la requête
        $stmt = $this->conn->prepare($this->query);                  // Préparation de la requête avec PDO
        return $stmt->execute([':id' => $id]);                      // Exécution avec le paramètre ID
    }

    // Relation "hasOne" avec UserInfoModel
    public function userInfo(){
        return $this->hasOne('UserInfoModel', 'user_id'); // Relation entre 'users' et 'users_infos'
    }
}