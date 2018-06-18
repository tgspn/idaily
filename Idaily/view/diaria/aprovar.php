<?php
$model = ViewHelper::GetModel();
?>
<div class="col-md-6">
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">Data</th>
        <th scope="col">Tipo de Diaria</th>
        <th scope="col">Solicitante</th>
        <th scope="col">quantidade</th>
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
        </tr>';
      }
      ?>

    </tbody>
  </table>
</div>

<div class="col-md-6 detalhes">
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

<script>
  $("tr.row1").click(x => {
    
    var id=$(x.currentTarget).attr('data-id');
    $.ajax({
      url: "detalhes",
      data:{id: id},
      success: (data) => {
        $(".detalhes").html(data);
      }
    });
  });
</script>
