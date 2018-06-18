<?php
require_once 'model/diaria.php';
require_once 'model/diarioTipo.php';
require_once 'DAO/DAOBase.php';
require_once 'model/usuario.php';

class DiariaDAO extends DAOBase
{
  private $column;
  public function __construct()
  {
    parent::__construct("diaria");
    $this->column = "diaria.id,diaria_tipo_id,quantidade,data_criacao,status,pedido,diaria_tipo.nome,descricao,valor,solicitante_id,usuario.nome as solicitante";
  }
  public function Listar($filtro = '')
  {
    return $this->Select($this->column, $filtro, '', 'INNER JOIN diaria_tipo on diaria_tipo.id=diaria_tipo_id INNER JOIN usuario on solicitante_id=usuario.id');
  }

  public function Find($id)
  {
    return $this->Select($this->column, 'diaria.id=' . $id, '', 'INNER JOIN diaria_tipo on diaria_tipo.id=diaria_tipo_id INNER JOIN usuario on solicitante_id=usuario.id')[0];
  }

  protected function FillObject($row)
  {
    $diario = new Diaria();
    $diario->setId($row["id"]);
    $diario->setQuantidade($row["quantidade"]);
    $diario->setDataCriacao($row["data_criacao"]);
    $diario->setStatus($row["status"]);
    $diario->setPedido($row["pedido"]);

    $dt = new DiarioTipo();
    $dt->setId($row["diaria_tipo_id"]);
    $dt->setNome($row["nome"]);
    $dt->setDescricao($row["descricao"]);
    $dt->setValor($row["valor"]);
    $diario->setDiariaTipo($dt);

    $usuario = new Usuario();
    $usuario->setId($row["solicitante_id"]);
    $usuario->setNome($row["solicitante"]);
    $diario->setSolicitante($usuario);

    return $diario;
  }

  public function Salvar($obj)
  {
    if (is_null($obj->getId())) {
      $id = $this->Insert(
        "quantidade,pedido,solicitante_id,status,diaria_tipo_id",
        $obj->getQuantidade() . ",'" . $obj->getPedido() . "'," . $obj->getSolicitante()->getId() . ",'" . $obj->getStatus() . " '," . $obj->getDiariaTipo()->getId()
      );
      $obj->setId($id);
    } else {

      $str =
        " quantidade=" . $obj->getQuantidade() .
        ", pedido=' " . $obj->getPedido() . " '" .
        ", solicitante_id=" . $obj->getSolicitante()->getId() .
        ", status='" . $obj->getStatus() . "'";

      $this->Update($str, $obj->getId());
    }
  }
}
