<?php
require_once "DAO/userDAO.php";

class UserController
{

  public function UserLogado()
  {
    return $_SESSION["loggedIn"] === "true";
    //return isset($_SESSION["snome"]);
  }
  public function Cadastrar($nomeusuario, $senha, $confirmarsenha, $nome, $user_type, $email)
  {
    $dao = new userDAO();

    // Se o usuário não preencheu um dos campos é redirecionado à pagina de login
    if (!$nomeusuario || !$senha || !$confirmarsenha || !$nome || !$user_type || !$email) {
      header("Location: login.php?erro=3");
      exit;
    }

    // Se os valores dos campos senha e confirmação de senha forem diferentes
    if ($senha != $confirmarsenha) {
      header("Location: login.php?erro=5");
      exit;
    }
    $user = new User();
    $user->setNome($nome);
    $user->setEmail($email);
    $user->setPassword($senha);
    $user->setUser_type_id($user_type);
    $user->setUsername($nomeusuario);
    echo '<br/>Password: ' . $user->getPassword() . '<br/>';
    echo '<br/>Password2: ' . $password . '<br/>';
    try {

      if ($dao->CheckDisponibilidadeDeUsername($user->getUsername())) {

        if ($dao->Cadastrar($user)) {
          header("Location: index.php");
        }

      } else {
        header("Location: login.php?erro=6");
        exit;
      }
    } catch (Exception $err) {
      echo "Erro" . $err;
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
        header("Location: login.php?erro=2");
        exit;
      }


      $user = new User();
      $user->setUsername($nomeusuario);
      $user->setPassword($senha);

      if ($dao->Login($user)) {
        header("Location: index.php");

        exit;
      } else {
        header("Location: login.php?erro=1");
        exit;
      }

    } catch (Exception $err) {
      header("Location: login.php?erro=3");
    }

  }

  public function Logout()
  {
    $dao = new userDAO();
    $dao->Logout();
    header("Location: index.php");
  }
}


?>
