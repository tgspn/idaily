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


<div class="col-lg-12 text-center">
  <h1 class="mt-5">[Diárias]</h1>
  <div class="row justify-content-md-center">
    <div class="col-lg-4 text-left">
      <form class="register-form  needs-validation"  action="/login/Entrar" method="post" novalidate>
        <div class="form-group">
          <label for="nome">Nome</label>
          <input type="nome" class="form-control" id="username" name="username" placeholder="Usuário" autocomplete="off" required>
        </div>
        <div class="form-group">
          <label for="senha">Senha</label>
          <input type="password" class="form-control" id="password" placeholder="Senha" name="password"   autocomplete="off" required>
          <div class="invalid-feedback">A senha deve conter letras minúsculas, maiúscula e números</div>
       </div>
        <input class="form-check-input" type="hidden" name="papel_id" id="papel" value="4">

        	<button type="submit" class="btn btn primary">login</button>
      </form>
      <a href="/login/registro">Criar conta</a>
    </div>
  </div>
</div>
