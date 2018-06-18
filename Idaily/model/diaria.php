<?php
require_once 'model/diarioTipo.php';
class Diaria
{
  private $id;
  private $diariaTipo;
  private $quantidade;
  private $data_criacao;
  private $status;
  private $pedido;
  private $solicitante;

public function getId()
{
    return $this->id;
}

public function setId($id)
{
     $this->id = $id;
}

public function getDiariaTipo()
{
    return $this->diariaTipo;
}

public function setDiariaTipo($diariaTipo)
{
     $this->diariaTipo = $diariaTipo;
}

public function getQuantidade()
{
    return $this->quantidade;
}

public function setQuantidade($quantidade)
{
     $this->quantidade = $quantidade;
}

public function getDataCriacao()
{
    return $this->data_criacao;
}

public function setDataCriacao($data_criacao)
{
     $this->data_criacao = $data_criacao;
}

public function getStatus()
{
    return $this->status;
}

public function setStatus($status)
{
     $this->status = $status;
}

public function getPedido()
{
    return $this->pedido;
}

public function setPedido($pedido)
{
     $this->pedido = $pedido;
}


public function getSolicitante()
{
    return $this->solicitante;
}

public function setSolicitante($solicitante)
{
     $this->solicitante = $solicitante;
}
      }
 ?>
