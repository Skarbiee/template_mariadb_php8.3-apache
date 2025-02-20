<?php
// Import des classes nécessaires pour les modèles
require_once '../app/core/Model.php';
require_once '../app/models/ArticleModel.php';
require_once '../app/models/CategoryModel.php';
require_once '../app/models/ArticleContentModel.php';

// Initialisation des modèles
$articleModel = new ArticleModel();
$categoryModel = new CategoryModel();
$articlecontentModel = new ArticleContentModel();

// Récupération des données depuis la base de données
$articles = $articleModel->getAll();  // Articles avec leurs relations
$categories = $categoryModel->getAll();           // Toutes les catégories
$contents = $articlecontentModel->getAll();       // Tous les contenus d'articles


// Débogage (si nécessaire)
// echo '<pre>';
// echo "Articles:\n";
// print_r($articles);
// echo "\nCatégories:\n";
// print_r($categories);
// echo '</pre>';
?>

<!-- Affichage de la vue avec une table Bootstrap -->
<div class="articles-container">
    <h1>Articles</h1>

    <!-- <div class="category-filter">
        <label>Filtrer par catégorie:</label>
        <select name="category">
            <option value="all">Toutes les catégories</option>
            <?php if ($categories): ?>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>This HTML `<select>` element allows the user to filter the articles by category. The options are populated dynamically from the `$categories` array, which is retrieved from the `CategoryModel`. The "Toutes les catégories" (All categories) option is provided as the first option, with a value of "all".
        
    </div> -->

    <?php if ($articles): ?>
        <!-- Table d'affichage des articles -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Catégorie</th>
                    <th>Contenu</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article): ?>
                    <!-- Ligne d'article avec attribut data-category pour le filtrage -->
                    <tr class="article-row" data-category="<?= $article['category_id'] ?>">
                        <td><?= htmlspecialchars($article['title']) ?></td>
                        <td>
                            <?php if (isset($article['category_name'])): ?>
                                <?= htmlspecialchars($article['category_name']) ?>
                            <?php else: ?>
                                <em>Catégorie non définie</em>
                            <?php endif; ?>
                        </td>
                        <td>
                            <!-- Bouton pour ouvrir la modal avec le contenu de l'article -->
                            <button type="button" onclick="fetchData(<?= $article['id'] ?>)" class="btn-view rounded">
                                Voir l'article
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun article trouvé.</p>
    <?php endif; ?>
</div>

<!-- Modal pour afficher le contenu détaillé de l'article -->
<div id="articleModal" class="modal-overlay">
    <div class="modal-content">
        <span class="modal-close">&times;</span>
        <h2 id="modalTitle"></h2>
        <div id="modalContent"></div>
    </div>
</div>
