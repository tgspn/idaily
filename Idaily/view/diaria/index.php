<?php
$list=ViewHelper::GetModel();

function renderRow($row)
{
    return '<tr>
      <form action="Tipo" method="POST">
        <input type="hidden" name="id" value="'.$row->getId().'"/>
        <td>
          <input type="hidden" data-type="text" name="nome" value="'.$row->getNome().'">
          <label>'.$row->getNome().'</lable>
        </td>
        <td>
          <input type="hidden" data-type="text" name="descricao" value="'.$row->getDescricao().'">
          <label>'.$row->getDescricao().'</lable>
        </td>
        <td>
          <input type="hidden" data-type="number" name="valor" value="'.$row->getValor().'">
          <label>'.$row->getValor().'</lable>
        </td>
        <td >
          <a href="#" class="btn btn-success edit">Editar</a>
          <input type="hidden" value="&#x2713;" class="btn btn-defaul">
        </td>
      </form>
    </tr>';
}

 ?>
<div class="col-lg-12 text-center">
  <h1 class="mt-5">Tipo de Diárias</h1>
  <p class="lead">A baixo estão listados os tipos de diárias</p>

  <div class="col-lg-6">
    <div class="col text-left">
      <a href="#" id="novo" class="btn btn-primary">Novo</a>
    </div>
      <table class="table table-borderless" id="tipos">
        <thead>
          <tr>
            <th scope="col">Tipo</th>
            <th scope="col">Descrição</th>
            <th scope="col"> Valor</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($list  as $key => $value) {
              echo  renderRow($value);
          }
            ?>
        </tbody>
      </table>
  </div>
</div>

<script>
  $("#novo").click(x => {
    x.preventDefault();
    var newElement =
      '<form action="Tipo" method="POST">' +
      '<tr>' +
      '<td><input type="text" data-type="text" name="nome"></td>' +
      '<td><input type="text" data-type="text" name="descricao"></td>' +
      '<td><input type="number" data-type="number" name="valor"></td>' +
      '<td><a href="#" class="btn btn-success edit d-none">Editar</a>'+
      '<input type="submit" value="&#x2713;" class="btn btn-defaul">'+
      '</td>' +
        '</tr>';
      '</form>' +


    $("#tipos").append(newElement)
  })
</script>
