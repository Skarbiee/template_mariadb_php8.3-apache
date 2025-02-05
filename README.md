# Template MariaDB + PHP 8.3 Apache

Ce projet contient un **template Docker** pour un environnement de développement avec **MariaDB** et **PHP 8.3** avec **Apache**. Il fournit une configuration simple pour une application PHP avec une base de données MariaDB.

## Structure du projet

Voici un aperçu de la structure du projet :

```
./
├── docker-compose.yml        # Fichier de configuration Docker Compose
├── README.md                 # Ce fichier README
├── settings/                 # Dossier contenant les configurations Docker
│   ├── mariadb/              # Configuration spécifique à MariaDB (initialisation et autres)
│   │   └── init.sql          # Script SQL d'initialisation de la base de données
│   ├── config/               # Dossier contenant la configuration PHP et Apache
│   │   ├── 000-default.conf  # Configuration Apache (vHost)
│   │   ├── Dockerfile        # Dockerfile pour le conteneur PHP
│   │   └── entrypoint.sh     # Script d'entrée pour le conteneur PHP
├── src/                      # Code source de l'application
│   ├── public/               # Dossier public contenant l'index.php
│   │   ├── index.php         # Point d'entrée de l'application PHP
│   │   └── assets/           # Dossier contenant les images et autres ressources statiques
│   │       └── imgs/         # Dossier pour les images
│   └── app/                  # Code de l'application
│       └── classes/          # Dossier contenant les classes PHP
│           └── .gitignore    # Fichier .gitignore pour ignorer les fichiers spécifiques à ce répertoire
└── .env                      # Variables d'environnement pour Docker Compose
```

### Explication des sections :

- **Prérequis** : Liste des outils nécessaires pour exécuter ce projet (Docker, Docker Compose).
- **Installation** : Instructions pour configurer et démarrer le projet sur la machine locale.
- **Développement** : Explication sur la structure du projet, comment ajouter des extensions PHP, des scripts SQL, et comment modifier la configuration.
- **Commandes utiles** : Commandes Docker Compose pour gérer les conteneurs (démarrer, arrêter, supprimer volumes).
<!-- - **Licence** : Optionnelle si tu souhaites spécifier une licence. -->

## Prérequis

Avant de démarrer, assurez-vous que vous avez installé les éléments suivants sur votre machine :

- **Docker** : [Instructions d'installation Docker](https://docs.docker.com/get-docker/)
- **Docker Compose** : [Instructions d'installation Docker Compose](https://docs.docker.com/compose/install/)

## Installation

### 1. Cloner ce projet

Clonez ce projet sur votre machine :

```bash
git clone https://github.com/Skarbiee/template_mariadb_php8.3-apache.git
```

### 2. Modifier le fichier `.env`

Assurez-vous que le fichier `.env` est configuré avec vos paramètres :

```env
MYSQL_ROOT_PASSWORD=rootpassword
MYSQL_DATABASE=apache_db
MYSQL_USER=user
MYSQL_PASSWORD=password
```

### 3. Démarrer un serveur

#### **PHP**

Directement en php il est possible de démarrer un serveur grâce à la commande suivante dans votre bash:
```bash
php -S localhost:8080 -t ./src/public
```

#### **Docker**

Dans le répertoire où se trouve le fichier `docker-compose.yml`, exécutez la commande suivante pour démarrer les conteneurs Docker :

```bash
docker-compose up --build
```

- Le conteneur **PHP** sera disponible sur [http://localhost:8080](http://localhost:8080).
- Le conteneur **MariaDB** sera accessible sur le port `3306`.

### 4. Accéder à l'application

Une fois les conteneurs démarrés, vous pouvez accéder à votre application PHP à l'adresse suivante :

[http://localhost:8080](http://localhost:8080)

Vous pouvez également vous connecter à la base de données **MariaDB** avec les informations suivantes :

- **Hôte** : `localhost` ou `127.0.0.1`
- **Utilisateur** : `user`
- **Mot de passe** : `password`
- **Base de données** : `bdd_db`

### 5. Accéder à MariaDB

Pour accéder à MariaDB depuis votre machine, vous pouvez utiliser un client MySQL comme **DBeaver**, **MySQL Workbench**, ou **phpMyAdmin**.

- Hôte : `localhost`
- Port : `3306`
- Utilisateur : `user`
- Mot de passe : `password`

## Développement

- **Code source PHP** : Le code PHP est situé dans le répertoire `src/`.
- **Base de données** : MariaDB utilise le script `init.sql` pour initialiser la base de données avec une table `apache_db`.
- **Configuration Apache** : Le fichier `000-default.conf` contient la configuration d'Apache pour pointer vers le dossier `public/` de l'application PHP.

### Ajouter des extensions PHP

Si vous avez besoin d'ajouter des extensions PHP supplémentaires, vous pouvez modifier le **Dockerfile** situé dans `settings/config/Dockerfile`.

### Ajouter des scripts SQL

Si vous devez ajouter d'autres scripts SQL pour initialiser la base de données, vous pouvez les placer dans le répertoire `settings/mariadb/` et Docker les exécutera automatiquement.

## Commandes utiles

- **Démarrer les services** :

  ```bash
  docker-compose up --build
  ```

- **Arrêter les services** :

  ```bash
  docker-compose down
  ```

- **Supprimer les volumes (réinitialiser la base de données)** :

  ```bash
  docker-compose down -v
  ```

<!-- ## Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails. -->

---