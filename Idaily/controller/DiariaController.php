<?php
require_once "DAO/diariaDAO.php";
require_once "ControllerBase.php";
class DiariaController extends ControllerBase
{
  public function __construct()
  {
    parent::__construct("diaria");
  }
  public function Tipo($value = '')
  {
    $dao = new DiariaDAO();
    if ($this->IsPost()) {
      if ($this->IsValido()) {
        $obj = $this->ParseObj();
        $dao->Salvar($obj);
      }
      $this->setModel($dao->Listar());
      $this->RenderView("index");
    } else {
      $this->setModel($dao->Listar());
      $this->RenderView("index");
    }
  }
  private function IsValido()
  {
    $id = isset($_POST["id"]) ? addslashes(trim($_POST["id"])) : false;
    $nome = isset($_POST["nome"]) ? addslashes(trim($_POST["nome"])) : false;
    $descricao = isset($_POST["descricao"]) ? addslashes(trim($_POST["descricao"])) : false;
    $valor = isset($_POST["valor"]) ? addslashes(trim($_POST["valor"])) : false;

    return $nome && $descricao && $valor;
  }
  private function ParseObj()
  {
    $diario = new diarioTipo();
    $id = isset($_POST["id"]) ? addslashes(trim($_POST["id"])) : false;
    $nome = isset($_POST["nome"]) ? addslashes(trim($_POST["nome"])) : false;
    $descricao = isset($_POST["descricao"]) ? addslashes(trim($_POST["descricao"])) : false;
    $valor = isset($_POST["valor"]) ? addslashes(trim($_POST["valor"])) : false;

    if ($id) {
      $diario->setId($_POST["id"]);
    }

    $diario->setNome($_POST["nome"]);
    $diario->setDescricao($_POST["descricao"]);
    $diario->setValor($_POST["valor"]);

    return $diario;
  }
}
