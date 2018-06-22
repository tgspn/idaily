<style>
fieldset {
  border: 1px #ccc solid;
  border-radius: 5px;
  padding: 10px;
  margin-bottom: 10px;
}
fieldset legend{
  font-size: 17px;
}
</style>
<div class="col-lg-12 text-center">
  <h1 class="mt-5">Cadastro de usuários</h1>
  <div class="row justify-content-md-center">
    <div class="col-lg-4 text-left">
      <form class="register-form  needs-validation"  action="registro" method="post" novalidate>
        <div class="form-group">
          <label for="nome">Nome</label>
          <input type="nome" class="form-control" id="nome" name="nome" aria-describedby="nomeHelp" placeholder="Nome completo" autocomplete="off" required>
          <small id="nomeHelp" class="form-text text-muted">Campo obrigatório, preencha o nome completo</small>
        </div>
        <div class="form-group">
          <label for="usuario">Usuario</label>
          <input type="text" class="form-control" id="usuario" name="usuario" aria-describedby="usuarioHelp" placeholder="Usuario" autocomplete="off" required>
          <small id="usuarioHelp" class="form-text text-muted">O usuário será utilizado para fazer login no sistema</small>
        </div>
        <div class="form-group">
          <label for="senha">Senha</label>
          <input type="password" class="form-control" id="senha" placeholder="senha" name="senha"  pattern="([a-z]+[A-Z]+[0-9]+|[A-Z]+[a-z]+[0-9]+|[0-9]+[a-z]+[A-Z]+|[0-9]+[A-Z]+[a-z]+)" autocomplete="off" required>
          <div class="invalid-feedback">A senha deve conter letras minúsculas, maiúscula e números</div>
       </div>
        <div class="form-group">
          <label for="senha">Confirmar Senha</label>
          <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" placeholder="confirmar senha" autocomplete="off" required>
             <div class="invalid-feedback">A senha não são iguais</div>
        </div>
        <input class="form-check-input" type="hidden" name="papel_id" id="papel" value="4">

        <button type="submit" class="btn btn-primary">Salvar</button>
      </form>
    </div>
  </div>
</div>
<script>
var password = document.getElementById("senha")
  , confirm_password = document.getElementById("confirmar_senha");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>
