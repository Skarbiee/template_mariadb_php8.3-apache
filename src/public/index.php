<?php

require_once '../app/core/Functions.php';
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