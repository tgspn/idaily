<?php
require_once 'model/diaria.php';
require_once 'model/diarioTipo.php';
require_once 'DAO/DAOBase.php';
require_once 'model/usuario.php';
require_once 'model/GastoPorMes.php';
require_once 'model/GastoPorUsuario.php';

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
  public function GastoPorMes()
  {
    return $this->Select('month(data_criacao) mes,sum(  quantidade*valor) as gasto', '', 'group by month(data_criacao) order by month(data_criacao)', 'inner join diaria_tipo dt on dt.id=diaria_tipo_id');
  }
  public function GastoPorUsuario()
  {
    return $this->Select('us.nome, sum( quantidade*valor) gasto', '', 'group by us.id order by gasto desc, nome asc', 'inner join diaria_tipo dt on dt.id=diaria_tipo_id inner join usuario us on us.id=solicitante_id');
  }
  protected function FillObject($row)
  {
    if (isset($row["mes"]))
      return $this->setGastoPorMes($row);
    else if (isset($row["gasto"]))
      return $this->setGastoPorUsuario($row);
    else
      return $this->setDiaria($row);

  }
  public function setGastoPorMes($row)
  {
    $obj = new GastoPorMes();
    $obj->setMes($row["mes"]);
    $obj->setGasto($row["gasto"]);
    return $obj;
  }

  public function setGastoPorUsuario($row)
  {
    $obj = new GastoPorUsuario();
    $obj->setNome($row["nome"]);
    $obj->setGasto($row["gasto"]);
    return $obj;
  }
  public function setDiaria($row)
  {
    $diario = new Diaria();
    $diario->setId($row["id"]);
    $diario->setQuantidade($row["quantidade"]);
    $diario->setDataCriacao($row["data_criacao"]);
    $diario->setStatus($row["status"]);
    $diario->setPedido(str_replace('\r\n', "\r\n", $row["pedido"]));

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
        $obj->getQuantidade() . ",'" . str_replace("\r\n", '\r\n', $obj->getPedido()) . "'," . $obj->getSolicitante()->getId() . ",'" . $obj->getStatus() . " '," . $obj->getDiariaTipo()->getId()
      );
      $obj->setId($id);
    } else {

      $str =
        " quantidade=" . $obj->getQuantidade() .
        ", pedido='" . str_replace("\r\n", '\r\n', $obj->getPedido()) . "'" .
        ", solicitante_id=" . $obj->getSolicitante()->getId() .
        ", status='" . $obj->getStatus() . "'";

      $this->Update($str, $obj->getId());
    }
  }
}
