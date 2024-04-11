<?

namespace App\Controller;

use App\Model\dbConnect;
use App\Middleware\Auth;


class Usuarios
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
        "SELECT USU.*, FUN.nome_funcao, FUN.descricao
          FROM usuarios USU 
          INNER JOIN funcoes FUN ON (FUN.id = USU.id_funcao)
          ORDER BY USU.nome",
      ),
      true
    );


    print json_encode([
      "code" => 200,
      "message" => "success",
      "data" => $result
    ]);
  }

  public function Get($data)
  {
    extract($data);

    $result =  $this->db->retornarArray(
      $this->db->select(
        "SELECT USU.*
          FROM usuarios USU 
          WHERE id = ?     
          ORDER BY USU.nome",
        [$id_usuario]
      ),
      false
    );

    print json_encode([
      "code" => 200,
      "message" => "success",
      "data" => $result
    ]);
  }

  public function AtualizarUsuario($data)
  {
    extract($data);

    $post =  [$nome, $nome_usuario, $rua, $numero, $cep, $bairro, $cidade, $uf, $rg, $cpf, $id];

    $add_where = "";

    if (isset($senha)) {
      $post[] = md5($senha);
      $add_where = ", senha = ?";
    }

    $result = $this->db->execute(
      "UPDATE usuarios SET 
          nome = ?,
          nome_usuario = ?,
          rua = ?,
          numero = ?,
          cep = ?,
          bairro = ?,
          cidade = ?,
          uf = ?,
          rg = ?,
          cpf = ?
          $add_where
        WHERE id = ?",
      $post
    );

    print json_encode([
      "code" => $result ? 200 : 500,
      "message" =>  $result ? "success" : $this->db->getLastError(),
      "data" => []
    ]);
  }

  public function CadastrarUsuario($data)
  {
    extract($data);

    $result = $this->db->execute(
      "INSERT INTO usuarios SET 
          id_funcao = ?,
          nome = ?,
          nome_usuario = ?,
          senha = ?,
          rua = ?,
          numero = ?,
          cep = ?,
          bairro = ?,
          cidade = ?,
          uf = ?,
          rg = ?,
          cpf = ?",
      [$id_funcao, $nome, $nome_usuario, md5($senha), $rua, $numero, $cep, $bairro, $cidade, $uf, $rg, $cpf]
    );

    print json_encode([
      "code" => $result ? 200 : 500,
      "message" =>  $result ? "success" : $this->db->getLastError(),
      "data" => []
    ]);
  }
}
