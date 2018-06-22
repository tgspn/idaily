<?php
$model = ViewHelper::GetModel();

function GetValue($key)
{
  $url = $_SERVER['REQUEST_URI'];
  $parts = parse_url($url);
  $query = [];
  if (array_key_exists("query", $parts) && $parts["query"]) {
    parse_str($parts['query'], $query);
  }

  if (array_key_exists($key, $query) && $query[$key])
    return $query[$key];

  return '';
}
?>
 <style>
 .col-md-6 .hide-md-6{
   display: none;
 }
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
 <link href="/css/bootstrap-datepicker.css" rel="stylesheet">

 <div class="col-lg-12 text-center">
   <h1 class="mt-5">Relatório de Diárias</h1>
    <form>
      <div class="row">
            <div class="col-md-2 "  >
              <div class="form-group1">
                <label for="usuario">Data Inicio</label>
                <input type="text" autocomplete="off"  style="width:150px;" class="form-control date" value="<?php echo GetValue('data_inicio') ?>" id="data_inicio" name="data_inicio" data-date-format="dd/mm/yyyy" data-language="pt-BR" data-provide="datepicker">
              </div>
              <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
              </div>
            </div>
            <div class="col-md-2 "  >
              <div class="form-group1">
                <label for="usuario">Data Fim</label>
                <input type="text" autocomplete="off" style="width:150px;" value="<?php echo GetValue('data_fim') ?>" class="form-control date" id="data_fim" name="data_fim" data-date-format="dd/mm/yyyy" data-language="pt-BR" data-provide="datepicker">
              </div>
              <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
              </div>
            </div>
            <div class="col-md-3 "  >
              <div class="form-group1">
                <label for="usuario">Solicitante</label>
                <input type="text" style="width:250px;" autocomplete="off" class="form-control" id="data_fim" name="solicitante" value="<?php echo GetValue('solicitante') ?>">
              </div>
            </div>
            <div class="col-md-2 "  >
              <div class="form-group1">
                <label for="usuario">Status</label>
                <select class="form-control" name="status">
                  <option value="" >Todos</option>
                  <option value='1' <?php echo GetValue('status') == '1' ? 'selected' : '' ?>>Aguardando</option>
                  <option value='2' <?php echo GetValue('status') == '2' ? 'selected' : '' ?>>Aprovado</option>
                  <option value='3' <?php echo GetValue('status') == '3' ? 'selected' : '' ?>>Pago</option>
                </select>
              </div>
            </div>
            <div class="col-md-2 "  >
              <div class="form-group1">
                <label for="usuario">Tipo</label>
                <select class="form-control" name="tipo">
                  <option value="">Todos</option>
                  <option value='2' <?php echo GetValue('tipo') == '2' ? 'selected' : '' ?>>Internacional</option>
                  <option value='1' <?php echo GetValue('tipo') == '1' ? 'selected' : '' ?>>Nacional</option>
                </select>
              </div>
            </div>
            <div class="col-md-1">
              <label for="usuario"></br></label>
              <input type="submit" class="form-control" value="Filtrar"/>
            </div>
        </div>
      </div>
    </form>
  </div>
  <br/>
  <div class="row">

    <div class="col-md-12 fixed">
     <table class="table table-hover">
       <thead>
         <tr>
           <th scope="col" width="50">Data</th>
           <th scope="col" width="150">Tipo de Diaria</th>
           <th scope="col" width="50">Solicitante</th>
           <th scope="col" width="50" class="hide-md-6">Quantidade</th>
           <th scope="col" width="50">Valor</th>
           <th scope="col" width="50">Status</th>
         </tr>
       </thead>
       <tbody>
         <?php

        foreach ($model as $key => $value) {
          $classe = "";
          $statusTexto = "";
          switch ($value->getSituacao()->getSituacao()) {
            case 'Aprovado':
              $classe = "table-info";
              break;
            case 'Aguardando':
              $classe = "table-warning";
              break;
            case 'Reprovado':
              $classe = "table-danger";
              break;
            case 'Pago':
              $classe = "table-success";
              break;
            default:
                 // code...
              break;
          }

          echo '<tr data-id="' . $value->getId() . '" class="row1 ' . $classe . '"">
               <td scope="row">' . StringHelper::ParseBrDate($value->getDiaria()->getDataCriacao()) . '</td>
               <td scope="row">' . $value->getDiaria()->getDiariaTipo()->getNome() . '</td>
               <td scope="row">' . $value->getSolicitante()->getNome() . '</td>
               <td scope="row" class="hide-md-6">' . $value->getDiaria()->getQuantidade() . '</td>
               <td scope="row">R$ ' . number_format($value->getDiaria()->getQuantidade() * $value->getDiaria()->getDiariaTipo()->getValor(), 2, ',', '.') . '</td>
               <td scope="row">' . $value->getSituacao()->getSituacao() . '</td>
             </tr>';
        }
        ?>

       </tbody>
     </thead>
     </table>
    </div>

    <div class=" collapse collapseble">
      <div class="card" >
        <div class="card-header">
          Detalhes
          <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
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
<script src="/js/bootstrap-datepicker.js"></script>
<script src="/js/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<script>
  $('.date').datepicker({
      language: "pt-BR"
  });
  $(".close").click(()=>{
    $(".collapseble").removeClass("col-md-6");
    $(".collapseble").addClass("collapse");
    $(".fixed").addClass("col-md-12");
    $(".fixed").removeClass("col-md-6");
  });
  $("tr.row1").click(x => {

    var id=$(x.currentTarget).attr('data-id');
    $.ajax({
      url: "detalhes",
      data:{id: id},
      success: (data) => {
        $(".card-board").html(data);

        $(".collapseble").addClass("col-md-6");
        $(".collapseble").removeClass("collapse");
        $(".fixed").removeClass("col-md-12");
        $(".fixed").addClass("col-md-6");
      }
    });
  });
</script>
