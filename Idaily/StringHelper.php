<?php
class StringHelper
{
  public static function startsWith($str, $needle)
  {
    $length = strlen($needle);
    return (substr($str, 0, $length) === $needle);
  }

  public static function endsWith($str, $needle)
  {
    $length = strlen($needle);

    return $length === 0 || (substr($str, -$length) === $needle);
  }
  public static function Join($join, array $arr)
  {
    $str = '';
    foreach ($arr as $key => $value) {
      if (!is_null($value) && $value !== "") {
        $str .= $value;
        $str .= $join;
      }
    }
    if (StringHelper::endsWith($str, $join)) {
      $length = strlen($str);
      $str = substr($str, 0, $length - 1);
    }

    return $str;
  }

  public static function ParseBrDate($data)
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
}
?>
