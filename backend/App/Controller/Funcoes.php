<?

namespace App\Controller;

use App\Model\dbConnect;


class Funcoes
{
  public $db, $router, $base_css, $base_routers, $base_template, $params_global = [], $templates, $loader, $twig, $View, $UserID, $targetDomain, $UserLogado;

  public function __construct($router)
  {
    $this->router = $router;
    $this->db   = new dbConnect();
  }

  public function Listar()
  {
    $result =  $this->db->retornarArray(
      $this->db->select(
        "SELECT FUN.*
          FROM funcoes FUN
          ORDER BY FUN.nome_funcao",
      ),
      true
    );


    print json_encode([
      "code" => 200,
      "message" => "success",
      "data" => $result
    ]);
  }
}
