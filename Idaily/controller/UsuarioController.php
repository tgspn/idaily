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
  

  public function Logout()
  {
    $dao = new userDAO();
    $dao->Logout();
    header("Location: /");
  }
}


?>
