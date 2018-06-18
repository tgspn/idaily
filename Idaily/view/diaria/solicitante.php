<?php
$model=ViewHelper::GetModel();
 ?>
 <style>
 .aprovado{
   background-color: yellow
 }
 .reprovado{
   background-color: red;
 }
 .aguardando{
   background-color: orange;
 }
 .pago{
   background-color: green;
 }

 #sidebar {
  /* for the animation */
  transition: margin 0.3s ease;
}

.collapsed {
  /* hide it for small displays*/
  display: none;
}

@media (min-width: 992px) {
  .collapsed {
    display: block;
    /* same width as sidebar */
    margin-left: -25%;
  }
}
 </style>
 <div class="col-lg-12 text-center">
   <h1 class="mt-5">Diárias</h1>
   <div class="row">
    <div class="col-md-1">
     <a href="novo" class="btn btn-primary">Nova solicitação</a>
    </div>
  </div>
  <br/>
  <div class="row">

    <div class="col-md-12 fixed">
     <table class="table table-hover">
       <thead>
         <tr>
           <th scope="col" width="50">Data</th>
           <th scope="col" width="150">Tipo de Diaria</th>
           <th scope="col" width="50">Quantidade</th>
           <th scope="col" width="50">Valor</th>
           <th scope="col" width="50">Status</th>
         </tr>
       </thead>
       <tbody>
         <?php

           foreach ($model as $key => $value) {
             $classe="";
             $statusTexto="";
             switch ($value->getStatus()) {
               case 'A':
                 $classe="table-info";
                 $statusTexto="Aprovado";
                 break;
                 case 'E':
                   $classe="table-warning";
                    $statusTexto="Aguardando";
                   break;
                   case 'R':
                     $classe="table-danger";
                      $statusTexto="Reprovado";
                     break;
                     case 'P':
                       $classe="table-success";
                        $statusTexto="Pago";
                       break;
               default:
                 // code...
                 break;
             }

             echo '<tr data-id="'. $value->getId() .'" class="row1 ' .$classe . '"">
               <th scope="row">' . StringHelper::ParseBrDate($value->getDataCriacao()). '</th>
               <td >'.$value->getDiariaTipo()->getNome().'</td>
               <td>'.$value->getQuantidade().'</td>
               <td>'.$value->getQuantidade()*$value->getDiariaTipo()->getValor().'</td>
               <td>'.$statusTexto.'</td>
             </tr>';
           }
          ?>

       </tbody>
     </thead>
     </table>
    </div>

    <div class=" collapse">
      <div class="card" >
        <div class="card-header">
          Detalhes
        </div>
      <div class="card-board">
        <div class="text-left col" >
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
        </div>
      </div>
      </div>
    </div>


  </div>
</div>


<script>
  $("tr.row1").click(x => {

    $(".collapse").addClass("col-md-6");
    $(".collapse").removeClass("collapse");
    $(".fixed").removeClass("col-md-12");
    $(".fixed").addClass("col-md-6");

    var id=$(x.currentTarget).attr('data-id');
    $.ajax({
      url: "detalhes",
      data:{id: id},
      success: (data) => {
        $(".card-board").html(data);
      }
    });
  });
</script>
