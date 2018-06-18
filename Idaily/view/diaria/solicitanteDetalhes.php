<?php
$model = ViewHelper::GetModel();
$historico = ViewHelper::GetViewBag('situacao');
?>
<div class="col">
  <br/>
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="true">Detalhes</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">Histórico</a>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
      <div class="text-left col" >
        <div>
          <strong>Data</strong>
          <span><?php echo StringHelper::ParseBrDate( $model->getDataCriacao()); ?></span>
        </div>
        <div>
          <strong>Tipo de diária</strong>
          <span><?php echo $model->getDiariaTipo()->getNome(); ?></span>
        </div>
        <div>
          <strong>Solicitante</strong>
          <span><?php echo $model->getSolicitante()->getNome(); ?></span>
        </div>
        <hr/>
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
            <th scope="col" width="50">situação</th>
            <th scope="col" >Observacao</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($historico  as $key => $value) {
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
