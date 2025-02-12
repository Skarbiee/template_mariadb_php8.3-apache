<?php

define('APP_DIR', '../app');
define('CORE_DIR', APP_DIR.'/core');
define('VIEW_DIR', APP_DIR.'views');
define('DEBUG', false);


function displayErrorsPHP() {
    if (DEBUG) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}
function dd(...$vars) {
    if (DEBUG) {
        ddf(...$vars);
    }
}

function ddf(...$vars) {
        echo '<pre>';
        foreach (func_get_args() as $arg) {
            print_r($arg);
        }
        echo '</pre>';
        die();
}
