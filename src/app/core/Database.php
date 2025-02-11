<?php
class Database {
    private $host = 'mariadb';      // hôte de la base de données
    private $db_name = 'bdd_db';    // nom de la base de données
    private $username = 'root';     // utilisateur de la base de données
    private $password = '*';        // mot de lpasse de l'utilisateur
    public $conn;                   // la connexion PDO

    // Méthode pour se connecter à la base de données
    public function connect(){
        try{
            $this->conn = new PDO(                                                  // PDO crée une connexion à la base de données
            "mysql:host=$this->host;dbname=$this->db_name",
            $this->username,
            $this->password
        );
            $this->conn->setAttribute(                                              // On définit le mode d'erreur PDO en exception
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