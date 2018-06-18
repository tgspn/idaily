<?php

require_once 'model/usuario.php';
require_once 'model/situacao.php';
require_once 'model/diaria.php';
class ViewDiariaSituacao
{

  private $id;
  private $usuario;
  private $data_situacao;
  private $situacao;
  private $solicitante;
  private $diaria;
  private $observacao;


  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function getUsuario()
  {
    return $this->usuario;
  }

  public function setUsuario($usuario)
  {
    $this->usuario = $usuario;
  }

  public function getDataSituacao()
  {
    return $this->data_situacao;
  }

  public function setDataSituacao($data_situacao)
  {
    $this->data_situacao = $data_situacao;
  }

  public function getSituacao()
  {
    return $this->situacao;
  }

  public function setSituacao($situacao)
  {
    $this->situacao = $situacao;
  }

  public function getSolicitante()
  {
    return $this->solicitante;
  }

  public function setSolicitante($solicitante)
  {
    $this->solicitante = $solicitante;
  }

  public function getDiaria()
  {
    return $this->diaria;
  }

  public function setDiaria($diaria)
  {
    $this->diaria = $diaria;
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
