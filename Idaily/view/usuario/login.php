<?php
session_start();
require_once '../controller/usuario.php';
$url = $_SERVER['REQUEST_URI'];
$parts = parse_url($url);
$query = [];
if (in_array("query", $parts)) {
  parse_str($parts['query'], $query);
}


if (in_array('erro', $query)) {
  $erro = $query['erro'];
  $mensagem = "";
  switch ($erro) {
    case "1":
      $mensagem = "Usuário ou senha errado";
      break;
    case "2":
      $mensagem = "Favor preencher os campos obrigatórios";
      break;
    case "3":
      $mensagem = "Erro ao conectar com o banco";
      break;
    default:
      break;
  }
  echo "<div style='color:red'>" . $mensagem . "</div><br/>";
}
?>
<form action="login.php" method="post" class="login-form">
	<input type="hidden" name="action" value="login"/>
	<input type="text" name="username" placeholder="username"/>
	<input type="password" name="password" placeholder="password"/>
	<button type="submit">login</button>
</form>

<form class="register-form"  action="login.php" method="post">
	<input type="hidden" name="action" value="create"/>
	<input type="text" placeholder="nome" name="name"/>
	<input type="text"  placeholder="usário" name="username" />
	<input type="password" placeholder="senha" name="password"/>
	<input type="password" placeholder="confirmar senha" name="confirm_password"/>
	<input type="text" placeholder="email address" name="email"/>
	<label class="radio-inline">
		 <input type="radio" name="user_type" value="2"/> Usuário
	</label>
	<label class="radio-inline">
			<input type="radio" name="user_type" value="3"/> Advogado
	</label>
	<button>create</button>
	<p class="message">Already registered? <a href="#">Sign In</a></p>
</form>

<?php
if (isset($_POST['action'])) {
  $debug = true;

  $controller = new UserController();
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


?>
