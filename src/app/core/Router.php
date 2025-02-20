<?php
namespace App\Core;

class Router{
    private $routes= [];

    public function addRoute($url, $controller, $method){
        $this->routes[$url] = ['controller' => $controller, 'method' => $method];
    }

    // Gérer la requête et appeler le bon contrôleur et la bonne méthode
    public function handleRequest(){
        $request = $_SERVER['REQUEST_URI'];
        // Retirer le préfixe public de l'URL si nécessaire
        $request = str_replace('/src/public', '', $request);

        if(array_key_exists($request, $this->routes)){
            // Récuperer le contrôleur et la méthode
            $controllerName = $this->routes[$request]['controller'];
            $method = $this->routes[$request]['method'];
            // Include le contrôleur et créer une instance
            require_once "../app/Controllers/$controllerName.php";
            $controller = new $controllerName();

            // Vérifier si la méthodee xiste dans le contrôler
            if(method_exists($controller, $method)){
                // Appeler la méthode du contrôleur
                $controller->$method();
            } else {
                echo "Méthode inexistante";
            }
        } else {
            echo "Page non trouvée";
        }
    }
}