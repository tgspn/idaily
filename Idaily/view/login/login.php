<?php
//session_start();
//require_once 'controller/usuario.php';
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
<form action="login/Entrar" method="post" class="login-form">
	<input type="hidden" name="action" value="login"/>
	<input type="text" name="username" placeholder="username"/>
	<input type="password" name="password" placeholder="password"/>
	<button type="submit">login</button>
</form>
