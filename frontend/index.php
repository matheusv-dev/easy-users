<?php
require_once "vendor/autoload.php";
require_once "config.php";
require_once "session.php";

use App\Controller\Middleware;
use CoffeeCode\Router\Router;

$router = new Router(URL_SITE);

/**
 * Rotas das paginas
 */

$router->namespace("App\Controller");

$router->get('/autenticate/', 'Login:ValidateSession', 'Login.ValidateSession');
$router->get('/login',        'Pages:Login',    'Pages.Login');


$router->get("/", "Pages:Home", "Pages.Home", Middleware::class);
$router->get("/exportar/excel/", "Exportar:excel", "Exportar.excel", Middleware::class);
$router->get("/exportar/pdf/", "Exportar:PDF", "Exportar.PDF", Middleware::class);

$router->get("/logout/", "Logout:logout", "Logout");

$router->dispatch();

if ($router->error()) {
    header("HTTP/1.1 " . $router->error() . " Unauthorized");
}
