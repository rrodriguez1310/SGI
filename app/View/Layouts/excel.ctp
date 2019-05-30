<?php
header ("Expires: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=SGI_Reporte_abonados.xls" );
header ("Content-Description: Exported as XLS" );
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
   <head>
      <title>Informe de abonados</title>
      <meta charset="utf-8">
   </head>
   <body>
     <?php echo $this->fetch('content'); ?>
   </body>
</html>
