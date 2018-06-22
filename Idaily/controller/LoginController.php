<?php
require_once 'ControllerBase.php';
require_once 'UsuarioController.php';
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
        $this->RedirectTo("index?erro=2");
        exit;
      }


      $user = new Usuario();
      $user->setUsuario($nomeusuario);
      $user->setSenha($senha);

      if ($dao->Login($user)) {
        unset($_SESSION["Tologin"]);
        $this->RedirectTo("/");

        exit;
      } else {
        $this->RedirectTo("index?erro=1");
        exit;
      }

    } catch (Exception $err) {
      $this->RedirectTo("index?erro=3");
    }
  }
  public function Registro()
  {
    if ($this->IsPost()) {

      $controller = new UsuarioController();

      $usuario = isset($_POST["usuario"]) ? addslashes(trim($_POST["usuario"])) : false;
      $senha = (strlen($_POST["senha"]) > 0) ? md5(trim($_POST["senha"])) : false;
      $confirmarsenha = (strlen($_POST["confirmar_senha"]) > 0) ? md5(trim($_POST["confirmar_senha"])) : false;
      $nome = isset($_POST["nome"]) ? addslashes(trim($_POST["nome"])) : false;
      $papel_id = isset($_POST["papel_id"]) ? addslashes(trim($_POST["papel_id"])) : false;


      if (!$usuario || !$senha || !$confirmarsenha || !$nome || !$papel_id) {
        $this->RedirectTo("registro?erro=2");
        exit;
      }

        // Se os valores dos campos senha e confirmação de senha forem diferentes
      if ($senha != $confirmarsenha) {
        $this->RedirectTo("registro?erro=5");
        exit;
      }

      $user = new Usuario();
      $papel = new Papel();
      $papel->setId($papel_id);

      $user->setNome($nome);
      $user->setSenha($senha);
      $user->setPapel($papel);
      $user->setUsuario($usuario);

      try {
        $dao = new userDAO();
        if ($dao->CheckDisponibilidadeDeUsername($user->getUsuario())) {

          if ($dao->Cadastrar($user)) {
            $this->RedirectTo("/");
          }

        } else {
          $this->RedirectTo("registro?erro=6");
          exit;
        }
      } catch (Exception $ex) {
        $this->RedirectTo("registro?erro=7");
      }

    } else {
      $this->RenderView("registro");
    }
  }
  public function Sair()
  {
    unset($_SESSION["Tologin"]);
    $dao = new userDAO();
    $dao->Logout();
    $this->RedirectTo("/");
  }
}
?>
