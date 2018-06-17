<?php
require_once 'ControllerBase.php';
require_once 'Dao/userDAO.php';
class LoginController extends ControllerBase
{
  public function __construct()
  {
    parent::__construct("login");
  }
  public function index()
  {
    $this->RenderView("login");
  }
  public function Entrar()
  {
    try {
      $dao = new userDAO();
      // Atribui os valores digitados no formulário aos campos correspondentes

      $nomeusuario = isset($_POST["username"]) ? addslashes(trim($_POST["username"])) : false;
      $senha = (strlen($_POST["password"]) > 0) ? md5(trim($_POST["password"])) : false;
      // Se o usuário não preencheu um dos campos é redirecionado à pagina de login
      if (!$nomeusuario || !$senha) {
        $this->RedirectTo("login?erro=2");
        exit;
      }


      $user = new Usuario();
      $user->setUsuario($nomeusuario);
      $user->setSenha($senha);

      if ($dao->Login($user)) {
        unset($_SESSION["Tologin"]);
        $this->RedirectTo("");

        exit;
      } else {
        $this->RedirectTo("login?erro=1");
        exit;
      }

    } catch (Exception $err) {
      $this->RedirectTo("login?erro=3");
    }
  }

  public function Sair()
  {
    unset($_SESSION["Tologin"]);
    $dao = new userDAO();
    $dao->Logout();
    $this->RedirectTo("");
  }
}
?>
