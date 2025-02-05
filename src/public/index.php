<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$request = $_SERVER['REQUEST_URI'];

function includeComponent($component){
    include __DIR__ . '/../app/views/layout/head.php';
    include __DIR__ . '/../app/views/layout/header.php';
    include __DIR__ . '/../app/views/' . $component . '.php';
    include __DIR__ . '/../app/views/layout/footer.php';

}

switch($request){
    case '/':
    case '/home';
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