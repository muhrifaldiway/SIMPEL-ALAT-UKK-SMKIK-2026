<?php
// index.php
session_start();

// MENDEFINISIKAN JALUR ROOT SECARA ABSOLUT
define('BASE_PATH', __DIR__);
// Menangkap parameter dari URL, default ke AuthController (Login)
$controller = isset($_GET['c']) ? $_GET['c'] : 'auth';
$action = isset($_GET['a']) ? $_GET['a'] : 'login';

// Format penamaan controller (contoh: AuthController)
$controllerName = ucfirst($controller) . 'Controller';
$controllerFile = 'controllers/' . $controllerName . '.php';

// Cek apakah file controller ada
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $obj = new $controllerName();
    
    // Cek apakah method/action ada di dalam controller tersebut
    if (method_exists($obj, $action)) {
        $obj->$action();
    } else {
        die("Error: Method '$action' tidak ditemukan di $controllerName!");
    }
} else {
    die("Error: Controller '$controllerName' tidak ditemukan!");
}
?>