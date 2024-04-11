<?php

namespace App\Controller;

use CoffeeCode\Router\Router;

class Middleware
{

  public function handle(Router $router)
  {
    $Auth = $_SERVER['HTTP_AUTHORIZATION'];

    $split_token = explode(" ", $Auth);

    $token = $split_token[1];

    $arrayData = json_decode(base64_decode($token), true);

    $Login = new Login($router);

    $response = $Login->UserExist(
      $arrayData['nome_usuario'],
      $arrayData['senha']
    );

    if (!$response) {
      return false;
    } else {
      return true;
    }
  }
}
