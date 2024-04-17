<?php

namespace App\Controller;

class Login
{
  public $db, $router, $base_css, $base_routers, $base_template, $params_global = [], $templates, $loader, $twig, $View, $UserID, $targetDomain, $UserLogado;

  public function __construct($router)
  {
    $this->router = $router;
  }

  public function ValidateSession($data)
  {
    $data = json_decode(base64_decode($_GET['auth']));

    @session_start();

    $_SESSION = [
      "USUARIO" => [
        "nome_usuario" => $data->nome_usuario,
        "senha" => $data->senha,
      ],
      "TOKEN" => $_GET['auth']
    ];

    $this->router->redirect("/");
  }
}
