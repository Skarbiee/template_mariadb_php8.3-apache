CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE users_infos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    bio TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE users_connexions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    last_login DATETIME,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category_id INT NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE articles_contents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    article_id INT NOT NULL,
    FOREIGN KEY (article_id) REFERENCES articles(id)
);

-- Supprimer le contenu si l'article est supprimé
ALTER TABLE articles_contents
ADD CONSTRAINT fk_article_id FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE;

INSERT INTO users (username, email, password) VALUES
('Alice', 'alice@example.com', 'password1'),
('Bob', 'bob@example.com', 'password2'),
('Charlie', 'charlie@example.com', 'password3');

INSERT INTO users_infos (user_id, bio) VALUES
(1, 'Je suis Alice, développeuse web.'),
(2, 'Bob, passionné par le cloud computing.'),
(3, 'Charlie, adepte du devops.');

-- Catégories enrichies
INSERT INTO categories (id, name) VALUES
(1, 'Technologie'),
(2, 'Santé'),
(3, 'Développement Web'),
(4, 'Base de données'),
(5, 'Cybersécurité'),
(6, 'Intelligence Artificielle');

-- Articles enrichis
INSERT INTO articles (id, title, category_id) VALUES
(1, "Introduction à PDO en PHP", 4),
(2, "Sécuriser vos requêtes SQL", 5),
(3, "Les bases du Machine Learning", 6),
(4, "JavaScript Asynchrone", 3),
(5, "Protection contre les attaques XSS", 5),
(6, "L'impact de l'IA sur la santé", 2),
(7, "Optimisation des requêtes SQL", 4),
(8, "Les frameworks PHP modernes", 3),
(9, "Cybersécurité en 2024", 5),
(10, "L'évolution du Deep Learning", 6);

-- Contenus d'articles enrichis
INSERT INTO articles_contents (id, content, article_id) VALUES
(1, "PDO (PHP Data Objects) est une extension PHP qui définit une interface légère et cohérente pour accéder aux bases de données en PHP. Les principaux avantages de PDO sont:\n\n
- Support de plusieurs types de bases de données\n
- Requêtes préparées pour prévenir les injections SQL\n
- Gestion des erreurs via les exceptions\n
- Interface orientée objet\n\n
Exemple pratique: [Code exemple d'utilisation PDO]", 1),

(2, "La sécurisation des requêtes SQL est cruciale pour protéger vos applications. Les principales mesures à prendre incluent:\n\n
- Utilisation systématique des requêtes préparées\n
- Validation et nettoyage des entrées utilisateur\n
- Principe du moindre privilège pour les comptes DB\n
- Échappement correct des caractères spéciaux\n\n
Démonstration des meilleures pratiques: [Exemples de code sécurisé]", 2),

(3, "Le Machine Learning est une branche de l'IA qui permet aux systèmes d'apprendre à partir des données. Concepts fondamentaux:\n\n
- Apprentissage supervisé vs non supervisé\n
- Algorithmes de classification et régression\n
- Validation croisée et évaluation des modèles\n
- Prévention du surapprentissage\n\n
Applications pratiques dans l'industrie: [Cas d'usage réels]", 3),

(4, "Le JavaScript asynchrone est essentiel pour créer des applications web performantes. Points clés:\n\n
- Promesses et async/await\n
- Gestion des callbacks\n
- Event Loop et pile d'exécution\n
- Meilleures pratiques pour les appels API\n\n
Exemples concrets d'implémentation: [Code démonstratif]", 4),

(5, "Les attaques XSS (Cross-Site Scripting) restent une menace majeure. Protection efficace:\n\n
- Échappement des sorties HTML\n
- Content Security Policy (CSP)\n
- Validation des entrées utilisateur\n
- HttpOnly cookies\n\n
Guide pratique de mise en œuvre: [Exemples de protection]", 5),

(6, "L'Intelligence Artificielle révolutionne le secteur de la santé par:\n\n
- Diagnostic assisté par IA\n
- Prédiction des risques médicaux\n
- Personnalisation des traitements\n
- Optimisation des processus hospitaliers\n\n
Études de cas et résultats: [Données et statistiques]", 6),

(7, "L'optimisation des requêtes SQL est cruciale pour les performances. Techniques principales:\n\n
- Indexation efficace\n
- Analyse des plans d'exécution\n
- Normalisation et dénormalisation\n
- Cache et materialized views\n\n
Exemples d'optimisation: [Requêtes avant/après]", 7),

(8, "Les frameworks PHP modernes apportent structure et efficacité:\n\n
- Architecture MVC\n
- Injection de dépendances\n
- ORM et migrations\n
- Tests automatisés\n\n
Comparaison des frameworks populaires: [Tableau comparatif]", 8),

(9, "Tendances cybersécurité 2024:\n\n
- Zero Trust Architecture\n
- Intelligence artificielle en sécurité\n
- Sécurité du cloud native\n
- Protection contre les ransomwares\n\n
Recommandations et bonnes pratiques: [Guide détaillé]", 9),

(10, "Avancées récentes en Deep Learning:\n\n
- Transformers et attention\n
- Apprentissage par renforcement\n
- Réseaux génératifs\n
- Optimisation des modèles\n\n
Applications et perspectives: [Études de cas]", 10);