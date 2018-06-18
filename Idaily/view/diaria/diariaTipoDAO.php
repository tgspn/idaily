<?php
require_once 'model/diarioTipo.php';
require_once 'DAO/DAOBase.php';
class DiariaTipoDAO extends DAOBase
{
  public function __construct()
  {
    parent::__construct("diaria_tipo");
  }
  public function Listar()
  {
    return $this->Select("id,nome,descricao,valor");
  }
  protected function FillObject($row)
  {
    $diario = new DiarioTipo();
    $diario->setId($row["id"]);
    $diario->setNome($row["nome"]);
    $diario->setDescricao($row["descricao"]);
    $diario->setValor($row["valor"]);

    return $diario;
  }

  public function Salvar($obj)
  {
    if (is_null($obj->getId())) {
      $id = $this->Insert("nome,descricao,valor", $obj->ToInsertString());
      $obj->setId($id);
    } else {
      $this->Update("id,nome,descricao,valor", $obj->ToUpdateString());
    }
  }
}
