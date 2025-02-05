<?php
class Model extends Database{
    protected $table;           // le nom de la table associée au modèle
    protected  $columns = [];   // les colonnes de la table
    protected $query;           // requête SQL

    // Initialisation de la table dans le constructeur
    public function __construct($table){
        parent::connect();                                  // Appel à la méthode de la classe parente pour se connecter
        $this->table = $table;                              // Initialisation du nom de la table
        $this->query = "SELECT * FROM " . $this->table;     // Requête de base
    }

    // Méthode pour définir les confition dans la requête (WHERE)
    public function where($column, $operator, $value){
        $this->query .= "WHERE " . $column . " $operator : value";
        $this->columns[':value'] = $value;                                  // Ajout de la valeur pour le placeholder
        return $this;
    }

    public function get(){
        $stmt = $this->conn->prepare($this->query);         // Préparation de la requête SQL
        $stmt->execute($this->columns);                    // Exécution de la requête
        return $stmt->fetchAll(PDO::FETCH_ASSOC);                  // Retourne tous les résultats sous forme de tableau associatif
    }

    public function select($columns){
        $this->query = "SELECT " . implode(',', (array) $columns) . " FROM " . $this->table; // Construction de la requête avec les colunnes spécifiées
        return $this;
    }

    // Méthode pour ajouter un enregistrement
    public function insert($data){
        $columns = implode(',', array_keys($data));                             // Colonnes à insérer
        $placeholders = ":" . implode(',:', array_keys($data));                 // PLaceholders pour les valeurs
        $this->query = "INSERT INTO " . $this->table . " ($columns) VALUES ($placeholders)";      // Requête d'insertion
        $stmt = $this->conn->prepare($this->query);                                        // Préparation de la requête
        return $stmt->execute($data);                                                     // Exécution de la requête avec les données à insérer
    }

    public function hasOne($relatedModel, $foreignKey){
        $related = new $relatedModel();                                                                     // Crée une instance du modèle lié
        $relatedTable = $related->table;
        $this->query .= " LEFT JOIN $relatedTable ON $relatedTable.$foreignKey = " . $this->table . ".id";
        return $this;                                                                                       // Permet de chaîner
    }

    public function hasMany($relatedModel, $foreignKey){
        $related = new $relatedModel();                                                                     // Crée une instance du modèle lié
        $relatedTable = $related->table;
        $this->query .= " LEFT JOIN $relatedTable ON $relatedTable.$foreignKey = " . $this->table . ".id";
        return $this;                                                                                       // Permet de chaîner
    }

    // Méthode pour remplacer un enregistrement dans la base de données
    public function replace($data){
        // On extrait les colonnes et leurs valeurs
        $columns = implode(',', array_keys($data));                 // Colonnes à insérer ou mettre à jour
        $placeholders = ":" . implode(',:', array_keys($data));     // Placeholders pour les valeurs

        // Construction de la requete REPLACE INTO
        $this->query = "REPLACE INTO " . $this->table . " ($columns) VALUES ($placeholders)";

        // Préparation et exécution de la requête
        $stmt = $this->conn->prepare($this->query);
        return $stmt->execute($data);               // Retourner true si l'opération a réussi
    }

    // Méthode pour supprimer un enregistrement de la base de données
    public function delete(){
        // Construction de la requête DELETE
        $this->query = "DELETE FROM " . $this->table;

        //Si des conditions WHERE sont définies, on les ajoute à la requête
        if(!empty($this->columns)){
            $this->query .= " WHERE " . key($this->columns) . " = :" . key($this->columns);
        }

        // Préparation et exécution de la requête
        $stmt = $this->conn->prepare($this->query);
        return $stmt->execute($this->columns);                        // Retourne true si la suppression a réussi
    }

    // Méthode pour définir une relation BelongsTo
    public function belongTo($relatedModel, $foreignKey){
        $related = new $relatedModel();                                                                         // Crée une instance du modèle lié
        $relatedTable = $related->table;
        $this->query .= " LEFT JOIN $relatedTable ON $relatedTable.id = " . $this->table . "." . $foreignKey;
        return $this;                                                                                           // Permet de chaîner
    }
}