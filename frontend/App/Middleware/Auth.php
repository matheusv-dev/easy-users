<?php

namespace App\Middleware;

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
