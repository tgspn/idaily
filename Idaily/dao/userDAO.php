<?php
require_once "base.php";
require_once "Model/usuario.php";
class userDAO
{

  public function Cadastrar(Usuario $usuario)
  {
    if ($this->CheckDisponibilidadeDeUsername($usuario->getUsuario())) {

      $id = executar_Insert_SQL("INSERT INTO usuario(papel_id,nome,usuario,senha)VALUES('".$usuario->getPapel()->getId()."','".$usuario->getNome()."','".$usuario->getUsuario()."','".$usuario->getSenha()."'");

      echo "lastId={$id}";
      $usuario->setid($id);
    } else {
      echo '<br/>' . $this->CheckDisponibilidadeDeUsername($user->getUsername()) . '<br/>';
      throw new exception('Já existe um usuário com esse nome');
    }
  }

  public function Login($user)
  {
    try {
      // Procura por um usuário com o mesmo nome de usuário
      $usuario = executar_SQL("SELECT * FROM users WHERE username = '" . $user->getUsername() . "' AND password = '" . $user->getPassword() . "'");

      $row = mysqli_fetch_assoc($usuario);
      echo "oi";

      if (!verifica_resultado($usuario)) {
        echo ("sem resultado");
        return false;
      } else {
        $user->setUser_type_id($row["user_type_id"]);
        $_SESSION["loggedIn"] = "true";
        $_SESSION["snome"] = $row["name"];
        $_SESSION["current_user"] = serialize($user);
        $parteResult = executar_SQL("SELECT * FROM partes WHERE user_id = {$row["id"]}");
        if (verifica_resultado($parteResult)) {
          $rowParte = mysqli_fetch_assoc($parteResult);
          $parte = new Parte();
          $parte->setid($rowParte["id"]);
          $parte->setDocumento($rowParte["documento"]);
          $_SESSION["current_parte"] = serialize($parte);

          echo "parte adicionada";
        }
        // Fecha conexão com o banco de dados
        desconectar($conexao);
        return true;
      }
    } catch (Exception $err) {
      throw $err;
    }

  }
  public function Log($value)
  {
    echo $value;
    echo "<script>console.log('{$value}');<script/>";
  }
  public function CheckDisponibilidadeDeUsername($username)
  {
    $result = executar_SQL("SELECT id FROM users WHERE username = '" . $username . "'");

    return !verifica_resultado($result);
  }

  public function Logout()
  {
    $_SESSION["loggedIn"] = "false";
    unset($_SESSION["snome"]);
    unset($_SESSION["parte"]);
  }
}



?>
