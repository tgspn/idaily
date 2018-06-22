<?php
$model = ViewHelper::GetModel();
$historico = ViewHelper::GetViewBag('situacao');
$statusTexto = "";
switch ($model->getStatus()) {
  case 'A':
    $classe = "table-info";
    $statusTexto = "Aprovado";
    break;
  case 'E':
    $classe = "table-warning";
    $statusTexto = "Aguardando";
    break;
  case 'R':
    $classe = "table-danger";
    $statusTexto = "Reprovado";
    break;
  case 'P':
    $classe = "table-success";
    $statusTexto = "Pago";
    break;
  default:
       // code...
    break;
}
?>
<div class="col-md-12">
  <h5>
    <span><?php echo $model->getSolicitante()->getNome(); ?></span>
  </h5>
  <fieldset>
    <div>
      <strong>Data</strong>
      <span><?php echo StringHelper::ParseBrDate($model->getDataCriacao()); ?></span>
    </div>
    <div>
      <strong>Tipo de diária</strong>
      <span><?php echo $model->getDiariaTipo()->getNome(); ?></span>
    </div>
    <div>
      <strong>Status</strong>
      <span><?php echo $statusTexto ?></span>
    </div>
    <div>
      <strong>Valor</strong>
      <span><?php echo 'R$ ' . number_format($model->getQuantidade() * $model->getDiariaTipo()->getValor(), 2, ',', '.'); ?></span>
    </div>
  </fieldset>
</div>
<hr/>
<div class="col">
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="true">Pedido</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">Histórico</a>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
      <div class="text-left col" >
        <div style="height:200px;overflow:auto">
          <article><?php echo $model->getPedido(); ?></article>
        </div>
        <br/>
      </div>

    </div>
    <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab" style="    height: 329px;overflow:auto">
      <table class="table">
        <thead>
          <tr>
            <th scope="col" width="50">Data</th>
            <th scope="col" width="50">Responsável</th>
            <th scope="col" width="50">Situação</th>
            <th scope="col" >Observação</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($historico as $key => $value) {
            echo '<tr>
                    <td>' . StringHelper::ParseBrDate($value->getDataSituacao()) . '</td>
                    <td>' . $value->getUsuario()->getNome() . '</td>
                    <td>' . $value->getSituacao()->getSituacao() . '</td>
                    <td>' . $value->getObservacao() . '</td>
                  </tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
