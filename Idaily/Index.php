<?php
session_start();
$GLOBALS["debug"] = false;
include_once 'model/papel.php';
include_once 'model/usuario.php';
require_once 'view/ViewHelper.php';
require_once 'StringHelper.php';

function __autoload($class_name)
{
  require_once 'controller/' . $class_name . '.php';
}
$isLogged = false;
$isAdmin = false;
$isAprovador = false;
if (isset($_SESSION["current_user"])) {
  $isLogged = true;
  $user = unserialize($_SESSION["current_user"]);

  if ($user->getPapel()->getNome() == "admin") {
    $isAdmin = true;
  }
  if ($user->getPapel()->getNome() == "Aprovador") {
    $isAprovador = true;
  }

} else if (!isToLogin()) {

  //$_SESSION["Tologin"] = true;
  header("Location:/Login");
  exit;
}
function isToLogin()
{
  $url = parse_url($_SERVER['REQUEST_URI']);
  $paths = explode("/", $url["path"]);
  $classe = count($paths) > 1 && strtolower($paths[1]) === "login";

  return $classe;
}
function RenderClass()
{
  $url = parse_url($_SERVER['REQUEST_URI']);
  $paths = explode("/", $url["path"]);
  $classe = count($paths) > 1 && $paths[1] !== "" ? $paths[1] : 'home';
  $metodo = count($paths) > 2 && $paths[2] !== "" ? $paths[2] : 'index';

  $file = 'controller/' . $classe . 'Controller.php';
  $classe .= "Controller";

  if (file_exists($file)) {
    require_once $file;

    $obj = new $classe();
    $obj->$metodo();
  } else {
    echo "Controler não encontrado";
  }
}
function GetErrorMensage()
{
  $url = $_SERVER['REQUEST_URI'];
  $parts = parse_url($url);
  $query = [];
  if (array_key_exists("query", $parts) && $parts["query"]) {
    parse_str($parts['query'], $query);
  }

  if (array_key_exists("erro", $query) && $query["erro"]) {
    $erro = $query['erro'];
    $mensagem = "";
    switch ($erro) {
      case "1":
        $mensagem = "Usuário ou senha errado";
        break;
      case "2":
        $mensagem = "Favor preencher os campos obrigatórios";
        break;
      case "3":
        $mensagem = "Erro ao conectar com o banco";
        break;
      case "5":
        $mensagem = "As senhas não confere";
        break;
      case "6":
        $mensagem = "Nome de usuário já em uso";
        break;
      case "7":
        $mensagem = "Erro desconhecido ao criar usuário";
        break;
      default:
        break;

    }
    echo "<div style='color:red'>" . $mensagem . "</div><br/>";
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Tiago Spana">

  <title>Sistema de gerenciamento de diárias</title>

  <!-- Bootstrap core CSS -->
  <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="/vendor/jquery/jquery.min.js"></script>
  <!-- Custom styles for this template -->
  <style>
    body {
      padding-top: 54px;
    }

    @media (min-width: 992px) {
      body {
        padding-top: 56px;
      }
    }
  </style>
  <style>
  fieldset {
    border: 1px #ccc solid;
    border-radius: 5px;
    padding: 10px;
    margin-bottom: 10px;
  }
  fieldset legend{
    font-size: 17px;
  }
  </style>
</head>

<body>
  <?php
  if($isLogged){
echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="/">IDaily</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">';


          if ($isLogged) {
            echo '  <li class="nav-item active">
                <a class="nav-link" href="/">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li>';
            if ($isAdmin) {
              echo '<li class="nav-item">
              <a class="nav-link" href="/usuario">Usuarios</a>
              </li>';
              // echo '<li class="nav-item">
              //   <a class="nav-link" href="/Diaria/Tipo">Tipo de diária</a>
              //   </li>';
            }
            if (ViewHelper::InPapel("aprovador")) {
              echo '<li class="nav-item">
              <a class="nav-link" href="/Diaria/Listar">Minhas Diarias</a>
            </li>';
              echo '<li class="nav-item">
              <a class="nav-link" href="/Diaria/Aprovar">Aprovar Diarias</a>
            </li>';
            }

            if (ViewHelper::InPapel("solicitante")) {
              echo '<li class="nav-item">
              <a class="nav-link" href="/Diaria/Listar">Diarias</a>
            </li>';
            }

            if(ViewHelper::InPapel("auditor"))
            {
              echo '<li class="nav-item">
              <a class="nav-link" href="/Diaria/Listar">Minhas Diarias</a>
            </li>';
            echo '<li class="nav-item">
            <a class="nav-link" href="/Diaria/Pagar">Pagar Diarias</a>
          </li>';
            }
            if(ViewHelper::InPapel('admin')||ViewHelper::InPapel('auditor')||ViewHelper::InPapel('aprovador'))
            {
              echo "<li class='nav-item'><a href='/Diaria/Relatorio' class='nav-link'>Relatório</a></li>";
            }


            echo "<li class='nav-item'><a class='nav-link'>&nbsp;&nbsp;".ViewHelper::GetCurrentUser()->getNome()."</a></li>";

            echo '<li class="nav-item">
            <a class="nav-link" href="/Login/Sair">Sair</a>
          </li>';

          }
echo '
        </ul>
      </div>
    </div>
  </nav>';
}
  ?>
  <!-- Page Content -->
  <div class="container">

<?php
GetErrorMensage();
?>

    <div class="row">

          <?php

          RenderClass();
          ?>
    </div>
  </div>

  <!-- Bootstrap core JavaScript -->

  <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
  </script>
</body>

</html>
