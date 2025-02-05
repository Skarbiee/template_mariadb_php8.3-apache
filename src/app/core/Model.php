<?php
/**
 * @ Author: Mathéo Siron
 * @ Create Time: 2025-05-02 13:59:39
 * @ Modified by: Mathéo Siron
 * @ Modified time: 2025-05-02 13:59:39
 * @ Description: Classe de base de données pour gérer la connexion à la base de données.
 */

class Model extends Database {


    protected $table;           // Le nom de la table associée au model
    protected $columns = [];    // Les colonnes de la table
    protected $query;           // Requête SQL


    // Initialisation de latable dans le constructeur
    public function __construct($table) {
        parent::connect();                                 // Appel à la méthode de la classe parente pour se connecter
        $this->table = $table;                             //Initialisation du nom de la table
        $this->query = "SELECT * FROM " . $this->table;    // Requête de base
    }


    // Méthode pour définir des condition dans la requête (WHERE)
    public function where($column,$operator,$value) {
        $this->query .= " WHERE " . $column . "$operator :value";
        $this->columns[':value'] = $value;                           // Ajout de la valeur pour le placeholder
    }


    // Méthode pour exécuter la requête et récupérer les résultats
    public function get($index=null) {
        $stmt = $this->conn->prepare($this->query);    // Préparation de la requête SQL
        $stmt->execute($this->columns);                // Exécution de la requête
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);      // Retourner les résultats sous la forme d'un tableau associatif

        if (is_null($index)) {
            return $result;
        }
        return $result[$index];
    }


    // Méthode pour sélectionner une colonne spécifique
    public function select($columns) {
        $this->query = "SELECT " . implode(',',(array)$columns) . " FROM " . $this->table;    // Construction de la requête avec les colonnes spécifiées
        return $this;                                                                         // Permet de chainer les méthodes
    }


    // Méthode pour ajouter un enregistrement
    public function insert($data) {
        $columns = implode(',', array_keys($data));                                             // Colonnes à insérer
        $placeholders = ":" . implode(',;', array_keys($data));                                 // Placeholders pour les valeurs
        $this->query = "INSERT INTO " . $this->table . " ($columns) VALUES ($placeholders)";    // Requête d'insertion
        $stmt = $this->conn->prepare($this->query);                                             // Préparation de la requête

        return $stmt->execute($data);                                                           // Exécution de la requête avec les données à insérer
    }

    // RELATION ENTRE LES TABLES
    private function hasObject($relatedModel, $foreignKey) {
        $related = new $relatedModel();                                                                       // Crée une instance du modèle lié
        $relatedTable = $related->table;
        $this->query .= " LEFT JOIN $relatedTable ON $relatedTable.$foreignKey = " . $this->table . ".id";
        return $this;                                                                                         // Permet de chainer
    }

    // Méthode HasOne
    public function hasOne($relatedModel, $foreignKey) {
        return $this->hasObject($relatedModel, $foreignKey)->get(0);    // Récupère un résultat
    }


    // Méthode HasMany
    public function hasMany($relatedModel, $foreignKey) {
        return $this->hasObject($relatedModel, $foreignKey)->get();    // Récupère tout
    }


    // Méthode Replace
    public function replace($data) {
        // On extrait les colonnes et leurs valeurs
        $columns = implode(',', array_keys($data));                                               // Colonnes à insérer ou mettre à jour
        $placeholders = ":" . implode(',:', array_keys($data));                                 // Placeholders pour les valeurs

        // Construction de la requête REPLACE INTO
        $this->query = "REPLACE INTO " . $this->table . " ($columns) VALUES ($placeholders)";

        // Préparation et exécution de la requête
        $stmt = $this->conn->prepare($this->query);
        return $stmt->execute($data);                                                            // Retourne true si l'opération a reussie
    }

    // Méthode delete
    public function delete() {
        // Construction de la requête DELETE
        $this->query = "DELETE FROM " . $this->table;

        // Si des conditions where sont définies, on les ajoute à la requête
        if (!empty($this->columns)) {
            $this->query .= " WHERE " . key($this->columns) . " = " . key($this->columns);
        }

        // Préparation et exécution de la requête
        $stmt = $this->conn->prepare($this->query);
        return $stmt->execute($this->columns);                                                // Retourne true si l'opération a reussie
    }

    // Méthode BelongTo
    public function beongTo($relatedModel, $foreignKey) {
        $related = new $relatedModel();                                                                          // Crée une instance du modèle lié
        $relatedTable = $related->table;
        $this->query .= " LEFT JOIN $relatedTable ON $relatedTable.id = " . $this->table . "." . $foreignKey;
        return $this;                                                                                            // Permet de chainer
    }
}
?>