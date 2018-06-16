<?php
session_start();
$GLOBALS["debug"] = false;
include_once 'model/papel.php';
include_once 'model/usuario.php';

function __autoload($class_name)
{
  //$class_name = str_replace("Controller", "", $class_name);
  require_once 'controller/' . $class_name . '.php';
}

$isAdmin = false;
if (isset($_SESSION["current_user"])) {
  $user = unserialize($_SESSION["current_user"]);

  if ($user->getPapel()->getNome() == "admin") {
    $isAdmin = true;
  }
} else if (!isset($_SESSION['login']) || !$_SESSION["login"]) {
  $_SESSION["login"] = true;
  header("Location:Login");
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
  if ($parts["query"]) {
    parse_str($parts['query'], $query);
  }

  if ($query["erro"]) {
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

  <title>Bare - Start Bootstrap Template</title>

  <!-- Bootstrap core CSS -->
  <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

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

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="/">IDaily</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <?php
          if ($isAdmin) {
            echo '<li class="nav-item">
              <a class="nav-link" href="/usuario">Usuarios</a>
              </li>';
          }
          ?>

          <li class="nav-item">
            <a class="nav-link" href="#">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

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
  <script src="/vendor/jquery/jquery.min.js"></script>
  <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>