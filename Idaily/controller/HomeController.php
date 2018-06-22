<?php
require_once 'DAO/diariaDAO.php';
class HomeController
{
  public function index()
  {
    require_once "view/home/index.php";
  }

  public function GetTSV()
  {
    $dao = new DiariaDAO();
    $result = $dao->GastoPorMes();
    $str = "mes\tgasto\r\n";
    foreach ($result as $key => $value) {
      $str .= StringHelper::nome_mes($value->getMes()) ."\t". $value->getGasto();
      $str .= "\r\n";
    }

    ob_clean();
    $f = fopen('php://memory', 'w');
      // loop over the input array
   // foreach ($array as $line) {
          // generate csv lines from the inner arrays
    fwrite($f, $str);
    //}
      // reset the file pointer to the start of the file
    fseek($f, 0);
      // tell the browser it's going to be a csv file
    header('Content-Type: application/csv');
      // tell the browser we want to save it instead of displaying it
    header('Content-Disposition: attachment; filename=data.csv";');
      // make php send the generated csv lines to the browser
    fpassthru($f);

    //$this->array_to_csv_download($lines, "data.tsv", ' ');
    exit;
  }

  public function GetGastoUsuario()
  {
    $dao = new DiariaDAO();
    $result = $dao->GastoPorUsuario();
    $str = "usuario\tgasto\r\n";
    foreach ($result as $key => $value) {
      $str .=strtoupper( $value->getNome()) ."\t". $value->getGasto();
      $str .= "\r\n";
    }

    ob_clean();
    $f = fopen('php://memory', 'w');
      // loop over the input array
   // foreach ($array as $line) {
          // generate csv lines from the inner arrays
    fwrite($f, $str);
    //}
      // reset the file pointer to the start of the file
    fseek($f, 0);
      // tell the browser it's going to be a csv file
    header('Content-Type: application/csv');
      // tell the browser we want to save it instead of displaying it
    header('Content-Disposition: attachment; filename=data.csv";');
      // make php send the generated csv lines to the browser
    fpassthru($f);

    //$this->array_to_csv_download($lines, "data.tsv", ' ');
    exit;
  }
}

?>
