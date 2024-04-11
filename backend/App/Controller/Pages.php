<?

namespace App\Controller;

use App\Model\dbConnect;
use App\Middleware\Auth;


class Pages
{
  public $db, $router, $base_css, $base_routers, $base_template, $params_global = [], $templates, $loader, $twig, $View, $UserID, $targetDomain, $UserLogado;

  public function __construct($router)
  {
    $this->router = $router;
    $this->UserLogado = Auth::UsuarioLogado();

    if (!$this->UserLogado && $this->router->current()->route != "/login") {
      $this->router->redirect("/login/");
    }

    $this->db   = new dbConnect();
  }

  public function Home()
  {
    $base = file_get_contents('./App/View/base/main.php');
    $page = file_get_contents('./App/View/usuarios/index.php');

    $base = str_replace('[PAGE]', $page, $base);

    echo $base;
  }

  public function Login()
  {
    $base = file_get_contents('./App/View/login/index.php');

    echo $base;
  }
}
