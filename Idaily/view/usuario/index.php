<?php

$users = ViewHelper::GetModel();

function renderRow($nome, $usuario, $tipo)
{
    return '<tr>
            <th scope="col">' . $nome . '</th>
            <th scope="col">' . $usuario . '</th>
            <th scope="col">' . $tipo . '</th>
          </tr>';
}
?>

<div class="col-lg-12 text-center">
  <h1 class="mt-5">Lista de usuários</h1>
  <p class="lead">Lista completa de todos os usuários do sistema</p>
  <div class="text-left" style="margin-bottom:10px;">
    <a href="usuario/Novo" class="btn btn-primary ">Novo</a>
  </div>
  <table class="table table-sm">
    <thead>
      <tr>
        <th scope="col">Nome</th>
        <th scope="col">Usuario</th>
        <th scope="col">Tipo</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($users as $user => $value) {
          echo renderRow($value->getNome(), $value->getUsuario(), $value->getPapel()->getNome());
      }
      ?>
    </tbody>
  </table>
</div>
