<?php
require_once "DAO/userDAO.php";

class UsuarioController
{

  public function UserLogado()
  {
    return $_SESSION["loggedIn"] === "true";
    //return isset($_SESSION["snome"]);
  }
  public function Index()
  {
    $dao = new userDAO();
    $_SESSION["model"] = serialize($dao->Listar());
    require_once 'view/usuario/index.php';
  }

  public function Novo()
  {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {

      $controller = new UsuarioController();

      $usuario = isset($_POST["usuario"]) ? addslashes(trim($_POST["usuario"])) : false;
      $senha = (strlen($_POST["senha"]) > 0) ? md5(trim($_POST["senha"])) : false;
      $confirmarsenha = (strlen($_POST["confirmar_senha"]) > 0) ? md5(trim($_POST["confirmar_senha"])) : false;
      $nome = isset($_POST["nome"]) ? addslashes(trim($_POST["nome"])) : false;
      $papel_id = isset($_POST["papel_id"]) ? addslashes(trim($_POST["papel_id"])) : false;


      if (!$usuario || !$senha || !$confirmarsenha || !$nome || !$papel_id) {
        header("Location: novo?erro=2");
        exit;
      }

      // Se os valores dos campos senha e confirmação de senha forem diferentes
      if ($senha != $confirmarsenha) {
        header("Location: novo?erro=5");
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
            header("Location: /");
          }

        } else {
          header("Location: usuario/novo?erro=6");
          exit;
        }
      } catch (Exception $ex) {
        header("Location: usuario/novo?erro=7");
      }

    } else {
      require_once 'view/usuario/novo.php';
    }
  }
  public function Login()
  {
    try {
      $dao = new userDAO();
// Atribui os valores digitados no formulário aos campos correspondentes

      $nomeusuario = isset($_POST["username"]) ? addslashes(trim($_POST["username"])) : false;
      $senha = (strlen($_POST["password"]) > 0) ? md5(trim($_POST["password"])) : false;
      // Se o usuário não preencheu um dos campos é redirecionado à pagina de login
      if (!$nomeusuario || !$senha) {
        header("Location: login?erro=2");
        exit;
      }


      $user = new Usuario();
      $user->setUsuario($nomeusuario);
      $user->setSenha($senha);

      if ($dao->Login($user)) {
        header("Location: /");

        exit;
      } else {
        header("Location: login?erro=1");
        exit;
      }

    } catch (Exception $err) {
      header("Location: login?erro=3");
    }

  }

  public function Logout()
  {
    $dao = new userDAO();
    $dao->Logout();
    header("Location: /");
  }
}


?>
