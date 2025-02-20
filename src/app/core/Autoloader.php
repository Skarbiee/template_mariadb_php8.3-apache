<?php
namespace App\Core;

class Autoloader
{
    
    // autoload.php : Function d'autoloading personnalisée
    public function autoload($className)
    {
        // Remplace les \ par des / pour la compatibilité avec les chemins de fichiers
        $className = str_replace('\\', '/', $className);
        
        // Définis le chemin de base pour les classes
        $basePath = __DIR__ . '../../'; // Dossier des classes dans le projet
        
        // Construis le chemin complet vers la classe
        $filePath = $basePath . $className . '.php';
        
        // Vérifie si le fichier existe et inclut-le
        if (file_exists($filePath)) {
            require_once $filePath;
        }
    }

    /**
     * Enregistre la fonction Autoload avec le registre SPL Autoload.
     * Cela permet à la classe AutolOader de charger automatiquement les classes
     * Comme ils sont référencés tout au long de la demande.
     */
    public static function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }
}
