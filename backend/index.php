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
$router->post("/api/login/", "Login:Auth",  "Login.Auth");

$router->get("/api/funcoes/listar", "Funcoes:listar",  "Funcoes.listar", Middleware::class);
$router->get("/api/usuarios/listar", "Usuarios:listar",  "Usuarios.listar", Middleware::class);

$router->get("/api/usuario/{id_usuario}/", "Usuarios:Get", "Usuarios.Get", Middleware::class);
$router->put("/api/usuario/{id_usuario}/", "Usuarios:AtualizarUsuario", "Usuarios.AtualizarUsuario", Middleware::class);
$router->post("/api/usuario/", "Usuarios:CadastrarUsuario", "Usuarios.CadastrarUsuario", Middleware::class);


$router->dispatch();

if ($router->error()) {
    echo $router->error();
}
