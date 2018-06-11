<?php
// Para verificar se o arquivo já foi importado
if (!defined("CONST_BASE.PHP")) {
  define("CONST_BASE.PHP", "BASE.PHP importado");

// Constantes do servidor e do banco de dados
  define('S_SERVIDOR', 'localhost');
  define('BD_USUARIO', 'root');
  define('BD_SENHA', 'masterkey');
  define('BD_BASEDEDADOS', 'idaily');

//$conexao_sgbd = mysqli_connect(S_SERVIDOR, BD_USUARIO, BD_SENHA);
//$conexao_base = mysqli_select_db($conexao_sgbd, BD_BASEDEDADOS);
// Conecta ao MySQL e à base de dados sitedfch
  function conectar()
  {
	// Realiza uma conexao com o MySQL
    $conexao_sgbd = mysqli_connect(S_SERVIDOR, BD_USUARIO, BD_SENHA);
    if (!$conexao_sgbd)
      die('Não foi possível conectar ao banco de dados: ' . mysqli_error(conexao_sgbd));

	// Conecta à base de dados
    $conexao_base = mysqli_select_db($conexao_sgbd, BD_BASEDEDADOS);
    if (!$conexao_base)
      die('Não foi possível conectar à base de dados: ' . mysqli_error(conexao_base));

	// Retorna a base de dados
    return $conexao_sgbd;
  }

// Fecha conexão com MySQL
  function desconectar($conexao)
  {
    mysqli_close($conexao);
  }
  
// Executa uma consulta e retorna o resultado, se houver
  function executar_SQL($SQL)
  {
    if ($debug === true)
      echo '<br/>' . $SQL . '<br/>';
	// Realiza a consulta
    $conexao = conectar();
    $resultado = mysqli_query($conexao, $SQL);

    if (!$resultado)
      die('Não foi possível realizar a consulta: ' . mysqli_error($conexao));
    
	// Retorna o resultado da consulta
    return $resultado;
  }
  function executar_Insert_SQL($SQL)
  {
    echo '<br/>' . $SQL . '<br/>';
	// Realiza a consulta
    $conexao = conectar();
    $resultado = mysqli_query($conexao, $SQL);

    if (!$resultado)
      die('Não foi possível realizar a consulta: ' . mysqli_error($conexao));
    
	// Retorna o resultado da consulta
    return mysqli_insert_id($conexao);
  }
 

// Verifica se a consulta gerou algum resultado
  function verifica_resultado($resultado)
  {
    return (mysqli_num_rows($resultado) != 0);
  }

// Coloca uma tupla de uma consulta em um array associativo
  function retorna_linha($consulta)
  {
    return mysqli_fetch_assoc($consulta);
  }

// Libera a memória do resultado de uma query
  function libera_consulta($consulta)
  {
    mysqli_free_result($consulta);
  }

// Valida e converte a data no formato dd/mm/aaaa para o formato aaaa-mm-dd
  function valida_data($data)
  {
    if ($data[2] == "\\" || $data[5] == "\\")
      return false;

    $dia = intval(substr($data, 0, 2));
    $mes = intval(substr($data, 3, 4));
    $ano = intval(substr($data, 6));

    if (!checkdate($mes, $dia, $ano))
      return false;

    return $ano . "-" . $mes . "-" . $dia;
  }

// Converte a data no formato aaaa-mm-dd para o formato dd/mm/aaaa
  function converte_data($data)
  {
    $dia = intval(substr($data, 8));
    $mes = intval(substr($data, 5, 6));
    $ano = intval(substr($data, 0, 4));

    if (strlen($dia) == 1)
      $dia = "0" . $dia;
    if (strlen($mes) == 1)
      $mes = "0" . $mes;

    return $dia . "/" . $mes . "/" . $ano;
  }
// Conecta ao banco de dados
  $conexao = conectar();

// Recebe data e hora e retorna data convertida para o formato dd/mm/aaaa
  function retorna_data($datahora)
  {
    return converte_data(substr($datahora, 0, 10));
  }

// Recebe um número e retorna o mês correspondente
  function nome_mes($n)
  {
    switch ($n) {
      case 1:
        return "Janeiro";
        break;
      case 2:
        return "Fevereiro";
        break;
      case 3:
        return "Março";
        break;
      case 4:
        return "Abril";
        break;
      case 5:
        return "Maio";
        break;
      case 6:
        return "Junho";
        break;
      case 7:
        return "Julho";
        break;
      case 8:
        return "Agosto";
        break;
      case 9:
        return "Setembro";
        break;
      case 10:
        return "Outubro";
        break;
      case 11:
        return "Nobembro";
        break;
      case 12:
        return "Dezembro";
        break;
      default:
        return $n;
    }
  }

} // Fim o if(!defined("CONST_BASE.PHP")){
else {
  echo ('não');
}
?>
