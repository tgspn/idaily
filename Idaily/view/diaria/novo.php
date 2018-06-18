<form action="novo" method="post">
  <input type="hidden" name="data_criacao" value=""/>
  <input type="hidden" name="status" value=""/>
  <input type="hidden" name="data_criacao" value=""/>
  <?php
    echo '  <input type="hidden" name="solicitante_id" value="'.ViewHelper::GetCurrentUser()->getId().'"/>
      <input type="hidden" name="solicitante" value="'.ViewHelper::GetCurrentUser()->getNome().'"/>';
    ?>

  <div class="form-group">
    <label for="quantidade">Quantidade</label>
    <input type="number" class="form-control" id="quantidade" name="quantidade"  placeholder="Quantidade de diárias">
  </div>
  <fieldset>
    <legend>Tipo de diária</legend>
    <?php
        foreach (ViewHelper::GetViewBag("tipo") as $key => $value) {
          echo '<div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio_'.$value->getId().'" name="diaria_tipo_id" class="custom-control-input" value="'.$value->getId().'">
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
      <textarea class="form-control" id="pedido" rows="10" name="pedido"></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
