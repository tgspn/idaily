<?php
require_once 'model/diarioTipo.php';
require_once 'model/diaria.php';
require_once 'model/usuario.php';
require_once 'model/situacao.php';

class DiariaSituacao
{
  private $id;
  private $situacao;
  private $diaria;
  private $usuario;
  private $data_criacao;
  private $observacao;

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function getSituacao()
  {
    return $this->situacao;
  }

  public function setSituacao($situacao)
  {
    $this->situacao = $situacao;
  }

  public function getDiaria()
  {
    return $this->diaria;
  }

  public function setDiaria($diaria)
  {
    $this->diaria = $diaria;
  }

  public function getUsuario()
  {
    return $this->usuario;
  }

  public function setUsuario($usuario)
  {
    $this->usuario = $usuario;
  }

  public function getDataCriacao()
  {
    return $this->data_criacao;
  }

  public function setDataCriacao($data_criacao)
  {
    $this->data_criacao = $data_criacao;
  }


  public function getObservacao()
  {
    return $this->observacao;
  }

  public function setObservacao($observacao)
  {
    $this->observacao = $observacao;
  }
}
