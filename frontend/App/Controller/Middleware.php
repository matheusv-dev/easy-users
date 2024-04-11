<?php

namespace App\Controller;

use CoffeeCode\Router\Router;

class Middleware
{

  public function handle(Router $router)
  {
    @session_start();
    $USER = @$_SESSION["USUARIO"];

    if (!$USER) {

      $router->redirect("/login/");
    } else {
      return true;
    }
  }
}
