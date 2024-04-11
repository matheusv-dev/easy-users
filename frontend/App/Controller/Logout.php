<?

namespace App\Controller;

class Logout
{
  public $db, $router, $base_css, $base_routers, $base_template, $params_global = [], $templates, $loader, $twig, $View, $UserID, $targetDomain, $UserLogado;

  public function __construct($router)
  {
    $this->router = $router;
  }

  public function logout($data)
  {
    session_start();
    session_destroy();

    $this->router->redirect("/");
  }
}
