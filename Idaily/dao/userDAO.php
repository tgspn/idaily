<?php
require_once "base.php";
require_once "Model/usuario.php";
require_once "Model/papel.php";
class userDAO
{
  private function FillObject($row)
  {

    $user = new Usuario();
    $papel = new Papel();
    $papel->setid($row["papel_id"]);
    $papel->setNome($row["papel"]);
    $papel->setDescricao($row["descricao"]);

    $user->setPapel($papel);
    $user->setNome($row["nome"]);
    $user->setId($row["id"]);
    $user->setUsuario($row["usuario"]);

    return $user;
  }
  public function Listar()
  {
    $result = executar_SQL("SELECT usuario.id,papel_id,usuario.nome,usuario,senha,papel.nome as papel,descricao FROM usuario" .
      " inner join papel on papel.id=papel_id");
    $users = [];

    foreach ($result as $row => $value) {
      $user = $this->FillObject($value);
      if ($user != null)
        array_push($users, $user);
    }
    return $users;
  }
  public function Cadastrar(Usuario $usuario)
  {
    if ($this->CheckDisponibilidadeDeUsername($usuario->getUsuario())) {

      //$id = executar_Insert_SQL("INSERT INTO usuario(papel_id,nome,usuario,senha)VALUES('".$usuario->getPapel()->getId()."','".$usuario->getNome()."','".$usuario->getUsuario()."','".$usuario->getSenha()."'");
      $sql = "INSERT INTO usuario(papel_id,nome,usuario,senha)" .
        "VALUES('" . $usuario->getPapel()->getId() . "','" . $usuario->getNome() . "','" . $usuario->getUsuario() . "','" . $usuario->getSenha() . "');";
      $id = executar_Insert_SQL($sql);

      $usuario->setid($id);
      return true;
    } else {
      throw new exception('Já existe um usuário com esse nome');
    }
  }

  public function Login($user)
  {
    try {
      // Procura por um usuário com o mesmo nome de usuário
      $usuario = executar_SQL("SELECT usuario.id,papel_id,usuario.nome,usuario,senha,papel.nome as papel,descricao FROM usuario" .
        " inner join papel on papel.id=papel_id" .
        " WHERE usuario = '" . $user->getUsuario() . "' AND senha = '" . $user->getSenha() . "'");

      $row = mysqli_fetch_assoc($usuario);

      if (!verifica_resultado($usuario)) {
        echo ("sem resultado");
        return false;
      } else {
        $papel = new Papel();
        $papel->setid($row["papel_id"]);
        $papel->setNome($row["papel"]);
        $papel->setDescricao($row["descricao"]);
        $user->setPapel($papel);
        $user->setNome($row["nome"]);
        $user->setId($row["id"]);

        $_SESSION["loggedIn"] = "true";
        $_SESSION["snome"] = $row["nome"];
        $_SESSION["current_user"] = serialize($user);

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
    $result = executar_SQL("SELECT id FROM usuario WHERE usuario = '" . $username . "'");

    return !verifica_resultado($result);
  }

  public function Logout()
  {
    $_SESSION["loggedIn"] = "false";
    unset($_SESSION["snome"]);
    unset($_SESSION["parte"]);
    unset($_SESSION["current_user"]);
  }
}



?>
