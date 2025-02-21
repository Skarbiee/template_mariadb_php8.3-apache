<?php

use App\Core\Autoloader;
use function App\Core\displayErrorsPHP;
use function App\Core\dd;

require_once '../app/core/Autoloader.php';
require_once '../app/core/Functions.php';
Autoloader::register();

displayErrorsPHP();
dd(getenv());

$request = $_SERVER['REQUEST_URI'];

function includeComponent($component) {
    if (strpos($component, 'api/') === 0) {
        // Pour les routes API, on n'inclut pas le layout
        include __DIR__ . '/../app/views/' . $component . '.php';
    } else {
        // Pour les routes normales, on inclut le layout complet
        include __DIR__ . '/../app/views/layout/head.php';
        include __DIR__ . '/../app/views/layout/header.php';
        include __DIR__ . '/../app/views/' . $component . '.php';
        include __DIR__ . '/../app/views/layout/footer.php';
    }
}

$uri_formated = explode('?', $request);

switch($uri_formated[0]){
    case '/':
    case '/home':
        includeComponent('home');
        break;
    case '/contact':
        includeComponent('contact');
        break;
    case  '/articles':
        includeComponent('articles');
        break;
     case '/api/article':
        includeComponent('api/article');
        break;
    default:
        includeComponent('404');
        break;
}
