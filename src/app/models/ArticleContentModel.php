<?php

namespace App\Models;

use App\Core\Model;
use App\Models\ArticleModel;

class ArticleContentModel extends Model {
    // Définition de la table associée au modèle
    protected $table = 'articles_contents';
    protected $id;

    /**
     * Constructeur qui initialise la connexion à la table
     */
    public function __construct() {
        parent::__construct($this->table);
    }

    /**
     * Récupère le contenu d'un article par son ID
     * @param int $id Identifiant du contenu
     * @return array Données du contenu trouvé
     */
    public function getById($id){
        $this->id = $id;
        return $this->select('*')
                    ->where('id', '=', $id)
                    ->get(0);
    }

    /**
     * Récupère tous les contenus d'articles
     * @return array Liste de tous les contenus
     */
    public function getAll(){
        return $this->get();
    }

    /**
     * Définit la relation many-to-one avec l'article
     * Un contenu appartient à un seul article
     * @return Model Instance du modèle pour chaînage
     */
    public function article () {
        return $this->belongsTo(ArticleModel::class, "article_id", "id");
    }
}
