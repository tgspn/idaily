<?php
$model = ViewHelper::GetModel();
?>

<div class="col-lg-12 text-center">
  <h1 class="mt-5">Aprovar Diárias</h1>
  <br/>
  <div class="row">
    <div class="col-md-6">
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">Data</th>
          <th scope="col">Tipo de Diaria</th>
          <th scope="col">Solicitante</th>
          <th scope="col">quantidade</th>
          <th scope="col">Valor</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($model as $key => $value) {
          echo '<tr class="row1" data-id="' . $value->getId() . '">
            <th scope="row">' . $value->getDataCriacao() . '</th>
            <td>' . $value->getDiariaTipo()->getNome() . '</td>
            <td>' . $value->getSolicitante()->getNome() . '</td>
            <td>' . $value->getQuantidade() . '</td>
              <td>R$ ' . number_format($value->getQuantidade() * $value->getDiariaTipo()->getValor(), 2, ',', '.').'</td>
          </tr>';
        }
        ?>

      </tbody>
    </table>
  </div>

    <div class="col-md-6 detalhes text-left">
      <div style="width:540px">
        <fieldset>
          <legend>Solicitação</legend>
          <div>
          <strong>Data</strong>
          <span></span>
        </div>
        <div>
          <strong>Tipo de diária</strong>
        </div>
        <div>
          <strong>Solicitante</strong>
        </div>
        <hr/>
        <div  style="height:200px;overflow:auto">

        </div>
        <hr/>
        </fieldset>
      </div>
    </div>
  </div>
</div>
<script>
  $("tr.row1").click(x => {

    var id=$(x.currentTarget).attr('data-id');
    $.ajax({
      url: "Solicitacao",
      data:{id: id},
      success: (data) => {
        $(".detalhes").html(data);
      }
    });
  });
</script>
