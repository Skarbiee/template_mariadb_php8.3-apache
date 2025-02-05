<?php
class Database {
    private $host = 'mariadb';           // hôte de la base de données
    private $db_name = 'bdd_db';         // nom de la base de données
    private $username = 'root';         // utilisateur de la base de données
    private $password = '*';            // mot de lpasse de l'utilisateur
    public $conn;                      // la connexion PDO

    // Méthode pour se connecter à la base de données
    public function connect(){
        try{
            // PDO crée une connexion à la base de données
            $this->conn = new PDO(
            "mysql:host=$this->host;dbname=$this->db_name",
            $this->username,
            $this->password
        );
            // On définit le mode d'erreur PDO en exception
            $this->conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
            return $this->conn;                                                     // Retourner la connexion pour utilisation dans d'autres classes

        } catch (PDOException $e){
            echo "Erreur de connexion à la base de données: " . $e->getMessage();
            return null;                                                            // Retourne null en cas d'erreur
        }
    }
}