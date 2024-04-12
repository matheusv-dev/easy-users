<?

namespace App\Controller;

class Pages
{
  public $db, $router, $base_css, $base_routers, $base_template, $params_global = [], $templates, $loader, $twig, $View, $UserID, $targetDomain, $UserLogado;

  public function __construct($router)
  {
    $this->router = $router;
  }

  public function Home()
  {
    $base = file_get_contents('./App/View/base/main.php');
    $page = file_get_contents('./App/View/usuarios/index.php');

    $page = str_replace('[USUARIO_LOGADO]', $_SESSION['USUARIO']["nome_usuario"], $page);
    $page = str_replace('[TOKEN]', $_SESSION['TOKEN'], $page);
    $base = str_replace('[PAGE]', $page, $base);

    echo $base;
  }

  public function Login()
  {
    $base = file_get_contents('./App/View/login/index.php');

    echo $base;
  }
}
