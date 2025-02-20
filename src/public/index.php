<?php
namespace Public;

use App\Core\Autoloader;
use function App\Core\displayErrorsPHP;
use function App\Core\dd;

require_once '../app/core/Autoloader.php';
Autoloader::register();

displayErrorsPHP();
dd(getenv());

$request = $_SERVER['REQUEST_URI'];

function includeComponent($component){
    include '../app/views/layout/head.php';
    include '../app/views/layout/header.php';
    include '../app/views/' . $component . '.php';
    include '../app/views/layout/footer.php';
}


switch($request){
    case '/':
    case '/home':
        includeComponent('home');
        break;
    case '/contact':
        includeComponent('contact');
        break;
    default:
        includeComponent('404');
        break;
}
?>