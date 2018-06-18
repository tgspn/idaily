<?php
require_once 'model/diaria.php';
require_once 'model/diarioTipo.php';
require_once 'DAO/DAOBase.php';
require_once 'model/usuario.php';
require_once 'model/DiariaSituacao.php';

class DiariaSituacaoDAO extends DAOBase
{
  private $column = 'id,usuario_id,data_criacao,situacao_id,diaria_id,observacao';
  public function __construct()
  {
    //select * from

    parent::__construct("diaria_situacao");
  }

  public function Listar($where = '')
  {
    return $this->Select($this->column, $where, '', '', '');
  }
  protected function FillObject($row)
  {
    $obj = new DiariaSituacao();
    $obj->setId($row["id"]);
    $obj->setDataCriacao($row["data_criacao"]);
    $obj->setObservacao($row["observacao"]);

    $usuario = new Usuario();
    $usuario->setId($row["usuario_id"]);
    $obj->setUsuario($usuario);

    $diaria = new Diaria();
    $diaria->setId($row["diaria_id"]);
    $obj->setDiaria($diaria);

    $situacao = new Situacao();
    $situacao->setId($row["situacao_id"]);
    $obj->setSituacao($situacao);

    return $obj;
  }
  public function Find($id)
  {
    return $this->Select($this->column, 'id=' . $id, '', '')[0];
  }
  public function Salvar($obj)
  {
    if (is_null($obj->getId())) {
      $id = $this->Insert(
        "situacao_id,diaria_id,usuario_id,observacao",
        StringHelper::Join(",", array($obj->getSituacao()->getId(), $obj->getDiaria()->getId(), $obj->getUsuario()->getId(), "'" . $obj->getObservacao() . "'"))
      );
      $obj->setId($id);
    } else {
      $this->Update("id,situacao_id,diaria_id,usuario_id,observacao", $obj->ToUpdateString());
    }
  }
}
