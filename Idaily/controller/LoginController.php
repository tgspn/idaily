<?php
class LoginController
{
  public function index()
  {
    require_once 'View/login/login.php';
  }
  public function Entrar($value = '')
  {
    if (isset($_POST['action'])) {
      $debug = true;

      $controller = new UsuarioController();
      if ($_POST['action'] == 'login') {
        $controller->Login();
      } else {

        $nomeusuario = isset($_POST["username"]) ? addslashes(trim($_POST["username"])) : false;
        $senha = (strlen($_POST["password"]) > 0) ? md5(trim($_POST["password"])) : false;
        $confirmarsenha = (strlen($_POST["confirm_password"]) > 0) ? md5(trim($_POST["confirm_password"])) : false;
        $nome = isset($_POST["name"]) ? addslashes(trim($_POST["name"])) : false;
        $email = isset($_POST["email"]) ? addslashes(trim($_POST["email"])) : false;
        $user_type = isset($_POST["user_type"]) ? addslashes(trim($_POST["user_type"])) : false;

        $controller->Cadastrar($nomeusuario, $senha, $confirmarsenha, $nome, $user_type, $email);
      }

    }
  }
}
?>
