<?php
namespace App\Models;

use App\Core\Model;
use App\Models\ArticleModel;
class CategoryModel extends Model {
    // Définition de la table associée au modèle
    protected $table = 'categories';
    protected $id;

    /**
     * Constructeur qui initialise la connexion à la table
     */
    public function __construct(){
        parent::__construct($this->table);
    }

    /**
     * Récupère une catégorie par son ID
     * @param int $id Identifiant de la catégorie
     * @return array Données de la catégorie trouvée
     */
    public function getById($id){
        $this->id = $id;
        return $this->select('*')
                    ->where('id', '=', $id)
                    ->get(0);
    }

    /**
     * Récupère toutes les catégories
     * @return array Liste de toutes les catégories
     */
    public function getAll(){
        return $this->get();
    }

    /**
     * Définit la relation one-to-many avec les articles
     * Une catégorie peut contenir plusieurs articles
     * @return Model Instance du modèle pour chaînage
     */
    public function article () {
        return $this->hasMany(ArticleModel::class, "categorie_id", "id");
    }

    
}
