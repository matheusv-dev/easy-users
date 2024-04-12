<?

namespace App\Controller;

use App\Model\dbConnect;
use App\Middleware\Auth;

class Login
{
  public $db, $router, $base_css, $base_routers, $base_template, $params_global = [], $templates, $loader, $twig, $View, $UserID, $targetDomain, $UserLogado;

  public function __construct($router)
  {
    $this->router = $router;
    $this->db   = new dbConnect();
  }

  public function UserExist($nome_usuario, $senha)
  {
    $result =  $this->db->retornarArray(
      $this->db->select(
        "SELECT * FROM usuarios WHERE nome_usuario = ? AND senha = ?",
        [$nome_usuario, $senha]
      ),
      false
    );

    return !empty($result);
  }

  public function Auth($data)
  {
    $safePost = filter_input_array(INPUT_POST, ["nome_usuario" => FILTER_SANITIZE_STRING, "senha" => FILTER_SANITIZE_STRING]);

    if (!$safePost) {
      $safePost = $data;
    }

    $result = self::UserExist($safePost['nome_usuario'], md5($safePost['senha']));
    $response = [];

    if ($result) {
      $response = [
        "code" => 200,
        "message" => "Autenticado com sucesso.",
        "data" => $safePost
      ];
    } else {
      header("HTTP/1.1 401 Unauthorized");
      $response = [
        "code" => 401,
        "message" => "Usuário ou senha incorreto.",
        "data" => []
      ];
    }

    print json_encode($response);
  }
}
