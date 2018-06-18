<?php
require_once "DAO/diariaDAO.php";
require_once "DAO/diariaTipoDAO.php";
require_once "model/diaria.php";
require_once "ControllerBase.php";
require_once 'model/diariasituacao.php';
require_once 'DAO/DiariaSituacaoDAO.php';
require_once 'DAO/ViewDiariaSituacaoDAO.php';
class DiariaController extends ControllerBase
{
  public function __construct()
  {
    parent::__construct("diaria");
  }
  public function Listar()
  {
    $dao = new DiariaDAO();
    if ($this->InPapel("auditor")) {

      $this->SetModel($dao->Listar());
      $this->RenderView("auditor");
    } else if ($this->InPapel("solicitante")) {
      $list = $dao->Listar('solicitante_id=' . $this->currentUser->getId());
      $this->SetModel($list);
      $this->RenderView("solicitante");
    }

  }

  public function Aprovar()
  {
    $dao = new DiariaDAO();
    if ($this->IsPost()) {
      $id = $_POST["id"];
      $result = $dao->Find($id);
      $result->setStatus("A");//aprovado;

      $dao->Salvar($result);

      $daoSit = new DiariaSituacaoDAO();

      $ds = new DiariaSituacao();
      $ds->setDiaria($result);
      $us = new Usuario();
      $us->setId($this->currentUser->getId());
      $ds->setUsuario($us);

      $sit = new Situacao();
      $sit->setId(2);
      $ds->setSituacao($sit);
      $daoSit->Salvar($ds);

      $this->RedirectTo("/");

    } else {
      $result = $dao->Listar("status='E'");
      $this->SetModel($result);
      $this->RenderView("aprovar");
    }

  }
  public function Detalhes()
  {
    $dao = new DiariaDAO();
    if ($this->InPapel("aprovador")) {
      $id = $_GET["id"];
      $result = $dao->Find($id);
      $this->SetModel($result);
      $this->RenderView('aprovarDetalhes');
    } else if ($this->InPapel("solicitante")) {
      $daoSit = new ViewDiariaSituacaoDAO();
      $id = $_GET["id"];
      $result = $dao->Find($id);
      $this->SetModel($result);

      $sits = $daoSit->Listar("diaria_id=" . $id);
      $this->SetViewBag('situacao', $sits);
      $this->RenderView('solicitanteDetalhes');
    }
  }

  public function Novo()
  {
    $dao = new DiariaDAO();
    if ($this->IsPost()) {
      $diaria = $this->ParseToDiaria();
      $diaria->setStatus('E');//Entregue
      $dao->Salvar($diaria);
      $this->RedirectTo("Listar", null);
    } else {
      $daoTipo = new DiariaTipoDAO();
      $this->SetViewBag('tipo', $daoTipo->Listar());
      $this->RenderView("novo");
    }
  }


  public function Tipo($value = '')
  {
    $dao = new DiariaTipoDAO();
    if ($this->IsPost()) {
      if ($this->IsDTValido()) {
        $obj = $this->ParseDtObj();
        $dao->Salvar($obj);
      }

      $this->setModel($dao->Listar());
      $this->RenderView("index");
    } else {
      $this->setModel($dao->Listar());
      $this->RenderView("index");
    }
  }
  private function IsDTValido()
  {
    $id = isset($_POST["id"]) ? addslashes(trim($_POST["id"])) : false;
    $nome = isset($_POST["nome"]) ? addslashes(trim($_POST["nome"])) : false;
    $descricao = isset($_POST["descricao"]) ? addslashes(trim($_POST["descricao"])) : false;
    $valor = isset($_POST["valor"]) ? addslashes(trim($_POST["valor"])) : false;

    return $nome && $descricao && $valor;
  }
  private function ParseDtObj()
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

  private function ParseToDiaria()
  {

    $id = isset($_POST["id"]) ? addslashes(trim($_POST["id"])) : false;
    $diario = new Diaria();
    if ($id)
      $diario->setId($id);
    $diario->setQuantidade($_POST["quantidade"]);
    $diario->setDataCriacao($_POST["data_criacao"]);
    $diario->setStatus($_POST["status"]);
    $diario->setPedido($_POST["pedido"]);

    $dt = new DiarioTipo();
    $dt->setId($_POST["diaria_tipo_id"]);
    $dt->setNome($_POST["nome"]);
    $dt->setDescricao($_POST["descricao"]);
    $dt->setValor($_POST["valor"]);
    $diario->setDiariaTipo($dt);

    $usuario = new Usuario();
    $usuario->setId($_POST["solicitante_id"]);
    $usuario->setNome($_POST["solicitante"]);
    $diario->setSolicitante($usuario);

    return $diario;
  }
}
