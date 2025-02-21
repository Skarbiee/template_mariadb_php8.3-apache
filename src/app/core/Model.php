<?php
namespace App\Core;

use App\Core\Database;
use PDO;

class Model extends Database {
    protected $table;           // Le nom de la table associée au model
    protected $id;              // La clé primaire de la table
    protected $columns = [];    // Les colonnes de la table
    protected $query;           // Requête SQL
    private $query_origin = "SELECT * FROM ";


    // Initialisation de latable dans le constructeur
    public function __construct($table) {
        parent::connect();                             // appel à la méthode de la classe parente pour se connecter 
        $this->table = $table;                         // initialisation du nom de la table
        $this->query = "SELECT * FROM " . $this->table; // requête de base
        $this->intialize();
    }

    private function intialize() {
        $this->columns = [];
        $this->query = $this->query_origin . $this->table;
    }

    protected function setId($id=null): void {
        if (!is_null($id)) {
            $this->id = $id;
        }
    }

    // Méthode pour définir les conditions de la requête (WHERE) 
    public function where($column,$operator,$value) {
        $this->query .= " WHERE {$this->table}.$column$operator:value";
        $this->columns[':value'] = $value;                           // Ajout de la valeur pour le placeholder
    }


    //Méthode pour exécuter la requête et récupérer les résultats
    public function get($index=null) {
        $stmt = $this->conn->prepare($this->query);      // Préparation de la requête SQL
        $stmt->execute($this->columns);                 // Exécution de la requête
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);            // Retourner les résultats sous la forme d'un tableau associatif
        $this->intialize();

        if (is_null($index)) {
            return $result;
        }
        return $result[$index]??[];
    }


    // Méthode pour séléctionner une colonne spécifique
    public function select ($columns=[]): static {
        $cols = '*';
        if (!empty($columns)) {
            if (is_array($columns)) {
                $cols = implode(',', array: $columns); //colonnes spécifiées
            } else {
                $cols = $columns; //colonne unique spécifiée
            }
        }
        $this->query = "SELECT " . $cols . " FROM " . $this->table; //construction de la requête avec les colonnes spécifiées
        return $this;                                                                        //retourne l'objet modèle pour une utilisation en chaîne
    }


    //Méthode pour ajouter un enregistrement
    public function insert($data) {
        $columns = implode(',', array_keys($data));                                             // Colonnes à insérer
        $placeholders = ":" . implode(',;', array_keys($data));                                 // Placeholders pour les valeurs
        $this->query = "INSERT INTO " . $this->table . " ($columns) VALUES ($placeholders)";                      // Requête d'insertion
        $stmt = $this->conn->prepare($this->query);                                                        // Préparation de la requête
        return $stmt->execute($data);                                                                     // Exécution de la requête avec les données à insérer
    }

    //Méthode pour remplacer un enregistrement
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

    //Méthode pour supprimer un enrergistrement
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

    //Méthode pour définir une relation de BelongsTo
    //ajout de la propriété $primaryKey pour spécifier la colonne de clé primaire et rendre la méthode plus flexible
    // ajout de la variable cols pour récuperer les données de la table liée
    public function belongsTo($relatedModel, $foreignKey, $primaryKey='id') {
        $related = new $relatedModel();                                                                          // Crée une instance du modèle lié
        $relatedTable = $related->table;
        $this->query .= " LEFT JOIN $relatedTable ON $relatedTable.$primaryKey = " .  $this->get(0)[$foreignKey];
        return $this;                                                                                            // Permet de chainer
    }

    //Méthode privée qui permet d'éviter la répétition du code de hasMany et hasOne
    //ajout de la propriété $localKey pour spécifier la colonne de clé primaire et rendre la méthode plus flexible
    // private function hasObject($relatedModel, $foreignKey, $localKey = 'id') {
    //     $related = new $relatedModel();     //crée une instance du modèle lié
    //     // $relatedTable = $related->table;
    //     return $related->select(['*'])->where("$foreignKey", "=", $this->$localKey);
    // }

    private function hasObject($relatedModel, $foreignKey, $localKey="id") {
        $related = new $relatedModel();                                                                       // Crée une instance du modèle lié
        $relatedTable = $related->table;
        $this->query .= " LEFT JOIN $relatedTable ON $relatedTable.$foreignKey = " . $this->$localKey;
        return $this;                                                                                         // Permet de chainer
    }

    //Méthode pour définir une relation de HasOne
    public function hasOne($relatedModel, $foreignKey, $localKey="id") {
        return $this->hasObject($relatedModel, $foreignKey, $localKey)->get(0);    // Récupère un résultat
    }
    
    //Méthode pour définir une relation de HasMany
    public function hasMany ($relatedModel, $foreignKey, $localKey = 'id') {
        return $this->hasObject($relatedModel, $foreignKey, $localKey)->get(); //récupère tout
    }
}
?>

<!-- NOUVEAU MODEL MVC -->
 