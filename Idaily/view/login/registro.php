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
  <div class="col-lg-4 text-left">
  <form class="register-form "  action="registro" method="post">
    <div class="form-group">
      <label for="nome">Nome</label>
      <input type="nome" class="form-control" id="nome" name="nome" aria-describedby="nomeHelp" placeholder="Nome completo">
      <small id="nomeHelp" class="form-text text-muted">Campo obrigatório, preencha o nome completo</small>
    </div>
    <div class="form-group">
      <label for="usuario">Usuario</label>
      <input type="text" class="form-control" id="usuario" name="usuario" aria-describedby="usuarioHelp" placeholder="Usuario">
      <small id="usuarioHelp" class="form-text text-muted">O usuário será utilizado para fazer login no sistema</small>
    </div>
    <div class="form-group">
      <label for="senha">Senha</label>
      <input type="password" class="form-control" id="senha" placeholder="senha" name="senha">
    </div>
    <div class="form-group">
      <label for="senha">Confirmar Senha</label>
      <input type="password" class="form-control" id="senha" name="confirmar_senha" placeholder="confirmar senha">
    </div>
    <input class="form-check-input" type="hidden" name="papel_id" id="papel" value="4">
   
    <button type="submit" class="btn btn-primary">Salvar</button>
  </form>
  </div>
</div>
