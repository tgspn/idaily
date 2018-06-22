<?php
require_once "DAO/diariaDAO.php";
require_once "DAO/diariaTipoDAO.php";
require_once "model/diaria.php";
require_once "ControllerBase.php";
require_once 'model/diariasituacao.php';
require_once 'DAO/DiariaSituacaoDAO.php';
require_once 'DAO/ViewDiariaSituacaoDAO.php';
require_once 'model/GastoPorMes.php';
require_once 'model/diarioTipo.php';

class DiariaController extends ControllerBase
{
  public function __construct()
  {
    parent::__construct("diaria");
  }
  public function Listar()
  {
    $dao = new DiariaDAO();

    $list = $dao->Listar('solicitante_id=' . $this->currentUser->getId());
    $this->SetModel($list);
    $this->RenderView("solicitante");
  }
  public function Relatorio()
  {
    if ($this->InPapel("admin") || $this->InPapel("auditor") || $this->InPapel('aprovador')) {

      $dao = new ViewDiariaSituacaoDAO();
      $filtro = '';
      if (isset($_GET["solicitante"]) && trim($_GET["solicitante"]) != '') {
        $solicitante = addslashes(trim($_GET["solicitante"]));
        $filtro = " solicitante like '%" . $solicitante . "%'";
      }
      if (isset($_GET["status"]) && trim($_GET["status"]) != '') {
        $val = addslashes(trim($_GET["status"]));
        if ($filtro != '')
          $filtro .= ' AND ';
        $filtro .= " situacao_id = " . $val;
      }
      if (isset($_GET["tipo"]) && trim($_GET["tipo"]) != '') {
        $val = addslashes(trim($_GET["tipo"]));
        if ($filtro != '')
          $filtro .= ' AND ';
        $filtro .= " diaria_tipo_id = " . $val;
      }
      if (isset($_GET["data_inicio"]) && trim($_GET["data_inicio"]) != '') {
        $val = addslashes(trim($_GET["data_inicio"]));
        if ($filtro != '')
          $filtro .= ' AND ';
        $arr = explode('/', $val);
        $filtro .= " data_pedido >= '" . $arr[2] . '-' . $arr[1] . '-' . $arr[0] . "'";
      }
      if (isset($_GET["data_fim"]) && trim($_GET["data_fim"]) != '') {
        $val = addslashes(trim($_GET["data_fim"]));
        if ($filtro != '')
          $filtro .= ' AND ';
        $arr = explode('/', $val);
        $filtro .= " data_pedido <= '" . $arr[2] . '-' . $arr[1] . '-' . $arr[0] . "'";
      }
      $list = $dao->Listar($filtro);
      $this->SetModel($list);
      $this->RenderView('relatorio');

    } else {
      $this->RedirectTo("/", "");
    }
  }
  public function Pagar()
  {
    if (!$this->InPapel("auditor")) {
      $this->RedirectTo("/");
    } else {
      $dao = new DiariaDAO();
      if ($this->IsPost()) {
        $id = $_POST["id"];
        $result = $dao->Find($id);
        $result->setStatus("P");//Pago;

        $dao->Salvar($result);

        $daoSit = new DiariaSituacaoDAO();

        $ds = new DiariaSituacao();
        $ds->setDiaria($result);
        $us = new Usuario();
        $us->setId($this->currentUser->getId());
        $ds->setUsuario($us);

        $sit = new Situacao();
        $sit->setId(3);
        $ds->setSituacao($sit);
        $daoSit->Salvar($ds);

        $this->RedirectTo("/");

      } else {
        $result = $dao->Listar("status='A'");
        $this->SetModel($result);
        $this->RenderView("aprovar");
      }
    }
  }
  public function Aprovar()
  {
    if (!$this->InPapel("auditor") && !$this->InPapel("aprovador")) {
      $this->RedirectTo("/");
    } else {
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

  }
  public function Solicitacao()
  {
    $dao = new DiariaDAO();
    $id = $_GET["id"];
    $result = $dao->Find($id);
    $this->SetModel($result);
    $this->RenderView('aprovarDetalhes');
  }
  public function Detalhes()
  {
    $dao = new DiariaDAO();

    $daoSit = new ViewDiariaSituacaoDAO();
    $id = $_GET["id"];
    $result = $dao->Find($id);
    $this->SetModel($result);

    $sits = $daoSit->Listar("diaria_id=" . $id);
    $this->SetViewBag('situacao', $sits);
    $this->RenderView('solicitanteDetalhes');

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
    $diario->setPedido(addslashes(trim($_POST["pedido"])));

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
