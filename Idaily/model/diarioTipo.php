<?php

class DiarioTipo
{
    private $id;
    private $nome;
    private $descricao;
    private $valor;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    public function ToInsertString()
    {
        return "'".$this->nome."','".$this->descricao."',".$this->valor;
    }
    public function ToUpdateString()
    {
        return $this->id.",'".$this->nome."','".$this->descricao."',".$this->valor;
    }
}
