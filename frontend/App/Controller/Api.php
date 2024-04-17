<?php

namespace App\Controller;


class Api
{
  private $url, $user, $password, $header;

  function __construct($url_base, $user = "", $password = "", $header = "")
  {
    $this->url      = $url_base;
    $this->user     = $user;
    $this->password = $password;
    $this->header   = $header;
  }

  function setarAutenticacao($ch)
  {
    if ($this->user != "" && $this->password != "") {
      curl_setopt($ch, CURLOPT_USERPWD, $this->user . ":" . $this->password);
    }
  }
  function setupOpcoesPadrao($ch)
  {

    $header[] = 'Content-Type: application/json';
    if ($this->header) {
      $header[] = $this->header;
    }


    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  }
  function get($funcao)
  {
    $url = $this->url . $funcao;

    $ch       = curl_init($url);

    $this->setupOpcoesPadrao($ch);
    $this->setarAutenticacao($ch);

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
  }

  function post($funcao, $arrayPost)
  {
    $ch       = curl_init($this->url . $funcao);

    $this->setupOpcoesPadrao($ch);
    $this->setarAutenticacao($ch);

    if (!empty($arrayPost)) {
      $postdata = json_encode($arrayPost);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    }

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
  }

  function put($funcao, $arrayPost)
  {
    $ch       = curl_init($this->url . $funcao);

    $this->setupOpcoesPadrao($ch);
    $this->setarAutenticacao($ch);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

    if (!empty($arrayPost)) {
      $postdata = json_encode($arrayPost);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    }

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
  }

  function patch($funcao, $arrayPost = array())
  {
    $url = $this->url . $funcao;

    $ch       = curl_init($url);

    $this->setupOpcoesPadrao($ch);
    $this->setarAutenticacao($ch);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");

    if (!empty($arrayPost)) {
      $postdata = json_encode($arrayPost);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    }

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
  }

  function delete($funcao, $arrayPost = array())
  {
    $url = $this->url . $funcao;
    $ch       = curl_init($url);

    $this->setupOpcoesPadrao($ch);
    $this->setarAutenticacao($ch);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

    if (!empty($arrayPost)) {
      $postdata = json_encode($arrayPost);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    }

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
  }
}
