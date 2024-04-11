<?php

namespace App\Middleware;

use App\Model\geral;
use CoffeeCode\Router\Router;

class Auth
{
  static function UsuarioLogado($router): bool
  {

    $USER = @$_SESSION["USUARIO"];

    var_dump($USER);

    if ($USER)
      return true;
    else
      return false;
  }
}
