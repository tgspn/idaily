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
<div>
  <strong>Valor</strong>
  <span><?php echo 'R$ ' . number_format($model->getQuantidade() * $model->getDiariaTipo()->getValor(), 2, ',', '.') ?></span>
</div>

<hr/>
<div style="height:200px;overflow:auto">
  <article><?php echo $model->getPedido(); ?></article>
</div>
 <hr/>
 <div class="text-right">
   <?php if(ViewHelper::InPapel("auditor"))
   {
       echo '<a href="#" id="pagar" class="btn btn-success">Pagar</a>';
   }else
    {
       echo '<a href="#" id="aprove" class="btn btn-primary">Aprovar</a>';
   }?>

    <!--<a href="#" class="btn btn-danger">Recusar</a>-->
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

$('#pagar').click(x=>{
  x.preventDefault();

  $.ajax({
    url:"Pagar",
    data:{id:<?php echo $model->getId(); ?>},
    method:"Post",
    success:()=>{
      document.location.reload();
    }
  })
});
</script>
