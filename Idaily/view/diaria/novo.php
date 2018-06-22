<div class="col-lg-12 text-center">
  <h1 class="mt-5">Solicitação de Diárias</h1>
  <br/>
  <div class="row justify-content-md-center text-left">
    <div class="col-md-6">
      <form action="novo" method="post" class="needs-validation" novalidate>
        <input type="hidden" name="data_criacao" value=""/>
        <input type="hidden" name="status" value=""/>
        <input type="hidden" name="data_criacao" value=""/>
        <?php
          echo '  <input type="hidden" name="solicitante_id" value="'.ViewHelper::GetCurrentUser()->getId().'"/>
            <input type="hidden" name="solicitante" value="'.ViewHelper::GetCurrentUser()->getNome().'"/>';
          ?>

        <div class="form-group">
          <label for="quantidade">Quantidade</label>
          <input type="number" class="form-control" id="quantidade" name="quantidade"  placeholder="Quantidade de diárias" required>
        </div>
        <fieldset>
          <legend>Tipo de diária</legend>
          <?php
              foreach (ViewHelper::GetViewBag("tipo") as $key => $value) {
                echo '<div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="radio_'.$value->getId().'" name="diaria_tipo_id" class="custom-control-input" required value="'.$value->getId().'">
                    <input type="hidden" name="nome" value="'.$value->getNome().'"/>
                    <input type="hidden" name="descricao" value=""/>
                    <input type="hidden" name="valor" value=""/>
                    <label class="custom-control-label" for="radio_'.$value->getId().'">'.$value->getNome().'</label>
                  </div>';
              }
           ?>

        </fieldset>
        <div class="form-group">
            <label for="pedido">Solicitação</label>
            <textarea class="form-control" id="pedido" rows="10" name="pedido" maxlength="1000" required></textarea>
            <small id="count_message" class="form-text text-muted  float-right">0 restante</small>
        </div>
        <button type="submit" class="btn btn-primary">Solicitar</button>
      </form>
    </div>
  </div>
</div>

<script>
var text_max = 1000;
$('#count_message').html(text_max + ' restante');

$('#pedido').keyup(function() {
  var text_length = $('#pedido').val().length;
  var text_remaining = text_max - text_length;

  $('#count_message').html(text_remaining + ' restante');
});
</script>
