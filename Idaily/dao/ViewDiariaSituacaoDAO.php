<?php
require_once 'model/diaria.php';
require_once 'model/diarioTipo.php';
require_once 'DAO/DAOBase.php';
require_once 'model/usuario.php';
require_once 'model/situacao.php';
require_once 'model/ViewDiariaSituacao.php';
class ViewDiariaSituacaoDAO extends DAOBase
{
  private $column = '*';

  public function __construct()
  {
    parent::__construct("view_diaria_situacao");
  }

  public function Listar($where = '')
  {
    return $this->Select($this->column, $where, '', '');
  }
  protected function FillObject($row)
  {
    $obj = new ViewDiariaSituacao();
    $obj->setId($row["id"]);
    $obj->setDataSituacao($row["data_situacao"]);
    $obj->setObservacao($row["observacao"]);

    $usuario = new Usuario();
    $usuario->setId($row["usuario_id"]);
    $usuario->setNome($row["usuario"]);
    $obj->setUsuario($usuario);

    $situacao = new Situacao();
    $situacao->setId($row["situacao_id"]);
    $situacao->setSituacao($row["situacao"]);
    $obj->setSituacao($situacao);

    $solicitante = new Usuario();
    $solicitante->setId($row["solicitante_id"]);
    $solicitante->setNome($row["solicitante"]);
    $obj->setSolicitante($solicitante);

    $diaria = new Diaria();
    $diaria->setId($row["diaria_id"]);
    $diaria->setPedido($row["pedido"]);
    $diaria->setDataCriacao($row["data_pedido"]);
    $diaria->setQuantidade($row["quantidade"]);
    $diaria->setStatus($row["status"]);
    $obj->setDiaria($diaria);

    return $obj;
  }
  public function Find($id)
  {
    return $this->Select($this->column, 'id=' . $id, '', '')[0];
  }
  public function Salvar($obj)
  {

  }
}
