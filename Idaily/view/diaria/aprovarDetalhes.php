<?php
$model = ViewHelper::GetModel();
?>
<div style="width:540px">
<fieldset>
  <legend>Solicitação</legend>
  <div>
  <strong>Data</strong>
  <span><?php echo $model->getDataCriacao(); ?></span>
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
 <hr/>
 <div class="text-right">
    <a href="#" id="aprove" class="btn btn-primary">Aprovar</a>
    <a href="#" class="btn btn-danger">Recusar</a>
  </div>
</fieldset>
<div>
<script>
$('#aprove').click(x=>{
  x.preventDefault();

  $.ajax({
    url:"Aprovar",
    data:{id:<?php echo $model->getId(); ?>},
    method:"Post",
    success:()=>{
      document.location.reload();
    }
  })
})
</script>
