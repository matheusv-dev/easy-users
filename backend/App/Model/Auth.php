<?php

namespace App\Middleware;

use App\Model\geral;
use CoffeeCode\Router\Router;

class Auth
{
  static function UsuarioLogado(): bool
  {
    $USER = @$_SESSION["CLIENTE"];

    if ($USER)
      return true;
    else
      return false;
  }
}
