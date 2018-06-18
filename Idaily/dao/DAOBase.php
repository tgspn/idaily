<?php

/**
 *
 */
abstract class DAOBase
{
  protected $table;

  public function __construct($table)
  {
    if (!defined('BD_CONFIGURADO')) {
      define('BD_CONFIGURADO', 'true');

      define('S_SERVIDOR', 'localhost');
      define('BD_USUARIO', 'root');
      define('BD_SENHA', 'masterkey');
      define('BD_BASEDEDADOS', 'idaily');
    }
    $this->table = $table;
  }
  abstract protected function FillObject($row);
  abstract public function Salvar($obj);

  protected function Select($colunas = '', $where = '', $extra = '', $join = '')
  {
    $sql = $this->ConstruirSelect($colunas, $where, $extra, $join);

    $result = $this->executar_SQL($sql);

    return $this->Leitura($result);
  }
  protected function Insert($campos, $valores)
  {
    $sql = "INSERT INTO " . $this->table . " (" . $campos . " ) VALUES (" . $valores . ")";
    $id = $this->executar_Insert_SQL($sql);

    return $id;
  }

  protected function Update($valores, int $id)
  {
    $sql = "UPDATE " . $this->table . " SET " . $valores . " WHERE id = " . $id;
    $id = $this->executar_Insert_SQL($sql);

    return $id;
  }
  private function ConstruirSelect($colunas = '', $where = '', $extra = '', $join = '')
  {
    if (!isset($colunas)) {
      $colunas = '*';
    }

    $sql = "SELECT " . $colunas . " FROM " . $this->table;
    if ($join !== "")
      $sql .= " " . $join;
    if ($where !== "") {
      $sql .= " WHERE " . $where;
    }

    if ($extra !== "") {
      $sql .= " " . $extra;
    }
    return $sql;
  }
  private function Leitura($resultado)
  {
    $list = [];
    foreach ($resultado as $row => $value) {
      $val = $this->FillObject($value);
      if ($val != null) {
        array_push($list, $val);
      }
    }
        // Retorna o resultado da consulta
    return $list;
  }
  public function conectar()
  {
        // Realiza uma conexao com o MySQL
    $conexao_sgbd = mysqli_connect(S_SERVIDOR, BD_USUARIO, BD_SENHA);
    if (!$conexao_sgbd) {
      die('Não foi possível conectar ao banco de dados: ' . mysqli_error(conexao_sgbd));
    }

        // Conecta à base de dados
    $conexao_base = mysqli_select_db($conexao_sgbd, BD_BASEDEDADOS);
    if (!$conexao_base) {
      die('Não foi possível conectar à base de dados: ' . mysqli_error(conexao_base));
    }

        // Retorna a base de dados
    return $conexao_sgbd;
  }

    // Fecha conexão com MySQL
  public function desconectar($conexao)
  {
    mysqli_close($conexao);
  }
    // Executa uma consulta e retorna o resultado, se houver
  public function executar_SQL($SQL)
  {
        // if ($debug === true)
        //   echo '<br/>' . $SQL . '<br/>';
        // Realiza a consulta
    $conexao = $this->conectar();
    $resultado = mysqli_query($conexao, $SQL);

    if (!$resultado) {
      die('Não foi possível realizar a consulta: ' . mysqli_error($conexao));
    }

        // Retorna o resultado da consulta
    return $resultado;
  }

  public function executar_Insert_SQL($SQL)
  {
    //echo '<br/>' . $SQL . '<br/>';
        // Realiza a consulta
    $conexao = $this->conectar();
    $resultado = mysqli_query($conexao, $SQL);

    if (!$resultado) {
      die('Não foi possível realizar a consulta: ' . mysqli_error($conexao));
    }

        // Retorna o resultado da consulta
    return mysqli_insert_id($conexao);
  }


    // Verifica se a consulta gerou algum resultado
  public function verifica_resultado($resultado)
  {
    return (mysqli_num_rows($resultado) != 0);
  }

    // Coloca uma tupla de uma consulta em um array associativo
  public function retorna_linha($consulta)
  {
    return mysqli_fetch_assoc($consulta);
  }

    // Libera a memória do resultado de uma query
  public function libera_consulta($consulta)
  {
    mysqli_free_result($consulta);
  }
}
