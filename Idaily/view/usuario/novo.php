
<div class="col-lg-12 text-center">
  <h1 class="mt-5">Cadastro de usuários</h1>
  <div class="row justify-content-md-center">
    <div class="col col-lg-6   text-left">
    <form class="register-form needs-validation"  action="novo" method="post"   novalidate>
      <div class="form-group">
        <label for="nome">Nome</label>
        <input type="nome" class="form-control" id="nome" name="nome" aria-describedby="nomeHelp" placeholder="Nome completo" autocomplete="off" history="false" required>
        <small id="nomeHelp" class="form-text text-muted">Campo obrigatório, preencha o nome completo</small>
      </div>
      <div class="form-group">
        <label for="usuario">Usuario</label>
        <input type="text" class="form-control" id="usuario" name="usuario" aria-describedby="usuarioHelp"  placeholder="Usuario" autocomplete="off" required>

        <small id="usuarioHelp" class="form-text text-muted">O usuário será utilizado para fazer login no sistema</small>
      </div>
      <div class="form-group">
        <label for="senha">Senha</label>
        <input type="password" class="form-control" id="senha" placeholder="senha" name="senha" autocomplete="off" pattern="([a-z]+[A-Z]+[0-9]+|[A-Z]+[a-z]+[0-9]+|[0-9]+[a-z]+[A-Z]+|[0-9]+[A-Z]+[a-z]+)" required>

         <div class="invalid-feedback">A senha deve conter letras minúsculas, maiúscula e números</div>
      </div>
      <div class="form-group">
        <label for="senha">Confirmar Senha</label>
        <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" placeholder="confirmar senha"  autocomplete="off" required>
      <div class="invalid-feedback">A senha não é a mesma</div>
      </div>
      <fieldset>
        <legend>Papel</legend>
        <div class="custom-control custom-radio custom-control-inline">
          <input class="custom-control-input" type="radio" name="papel_id" id="papel" value="1" required>
          <label class="custom-control-label" for="papel">Administrador</label>
        </div>
      <div class="custom-control custom-radio custom-control-inline">
        <input class="custom-control-input" type="radio" name="papel_id" id="papel2" value="2" required>
        <label class="custom-control-label" for="papel2">Auditor</label>
      </div>
      <div class="custom-control custom-radio custom-control-inline">
        <input class="custom-control-input" type="radio" name="papel_id" id="papel3" value="3" required>
        <label class="custom-control-label" for="papel3">Aprovador</label>
      </div>
      <div class="custom-control custom-radio custom-control-inline">
        <input class="custom-control-input" type="radio" name="papel_id" id="papel4" value="4" required >
        <label class="custom-control-label" for="papel4">Solicitante</label>
      </div>
    </fieldset>
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
