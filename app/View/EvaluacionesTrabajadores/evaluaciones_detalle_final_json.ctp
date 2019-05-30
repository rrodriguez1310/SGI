<?PHP
  function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    $str = mb_convert_encoding($str, 'UTF-16LE', 'UTF-8');
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }  
  $filename = "puntaje_competencias" . date('Ymd') . ".xls";
  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel; charset=utf-8");
  $flag = false;
  foreach($respuesta as $row) {
    if(!$flag) {      
      echo implode("\t", array_keys($row)) . "\r\n";
      $flag = true;
    }
    array_walk($row, 'cleanData');
    echo implode("\t", array_values($row)) . "\r\n";
  }
  exit;