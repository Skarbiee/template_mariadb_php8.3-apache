<?php

namespace App\Models;

use App\Core\Model;
use App\Models\CategoryModel;
use App\Models\ArticleContentModel;

class ArticleModel extends Model {

    // Définition de la table associée au modèle
    protected $table = 'articles';
    protected $id;
    // Liste des champs autorisés pour le remplissage en masse
    protected $fillable = [
        'title',
        'category_id'
    ];
    protected $conditions = [];

    // Constructeur qui initialise la connexion à la table
    public function __construct(){
        parent::__construct($this->table);
    }


    public function id($id){
        $this->id = $id;
        return $this->get(0);
    }
    
    /**
     * Récupère un article spécifique par son ID
     * @param int $id Identifiant de l'article
     * @return array Article trouvé ou tableau vide
     */
    public function getById($id){
        $this->id=$id;
        $this->where('id', '=', $id);
        return $this->get(0);
    }
    
    /**
     * Récupère tous les articles de la base de données
     * @return array Liste de tous les articles
     */
    public function getAll(){
        return $this->get();
    }
    
    /**
     * Définit la relation one-to-one avec le contenu de l'article
     * @return Model Instance du modèle pour chaînage
     */
    public function content() {
        return $this->hasOne(ArticleContentModel::class, "article_id", "id");
    }
    
    /**
     * Définit la relation many-to-one avec la catégorie
     * @return Model Instance du modèle pour chaînage
     */
    public function category () {
        return $this->belongsTo(CategoryModel::class, "category_id", "id");
    }

    /**
     * Supprime un article par son ID
     * @param int $id Identifiant de l'article à supprimer
     * @return bool Succès ou échec de la suppression
     */
    public function deleteById($id){
        $this->query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($this->query);
        return $stmt->execute([':id' => $id]);
    }

    public function getByIdWithRelations($id) {
        $article = $this->getById($id);
        if (!$article) return null;
        
        $article['content'] = $this->content()->get(0);
        $article['category'] = $this->category()->get(0);
        
        return $article;
    }

    /*
    Charge les relations spécifiées pour l'article
    @param array $relations Liste des relations à charger
    @return ArticleModel Instance courante pour chaînage
    
    public function with($relations) {
        foreach ($relations as $relation) {
            if ($relation == 'category') {
                $this->belongsTo('CategoryModel', 'category_id');
            }
        }
        return $this;
    } */
    
    /*
    Récupère tous les articles avec leurs relations (catégorie et contenu)
    @return array Liste des articles avec leurs relations
    
    public function getAllWithRelations() {
        $this->query = "SELECT a.*, c.name as category_name, ac.content 
                        FROM " . $this->table . " a
                        LEFT JOIN categories c ON a.category_id = c.id
                        LEFT JOIN articles_contents ac ON a.id = ac.article_id";
        return $this->get();
    } */

    /*
    Récupère un article spécifique avec ses relations
    @param int $id Identifiant de l'article
    @return mixed Article avec ses relations ou null
    
    public function findByIdWithRelations($id): mixed {
        $this->query = "SELECT a.*, c.name as category_name, ac.content 
                        FROM " . $this->table . " a
                        LEFT JOIN categories c ON a.category_id = c.id
                        LEFT JOIN articles_contents ac ON a.id = ac.article_id
                        WHERE a.id = :id";
        $this->conditions = [':id' => $id];
        return $this->get(0);
    } */
}