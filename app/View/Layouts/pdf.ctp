<?php 
echo "hola";
require_once(APP . 'Vendor' . DS . 'dompdf' . DS . 'dompdf_config.inc.php');
spl_autoload_register('DOMPDF_autoload');
$dompdf = new DOMPDF();
$dompdf->set_paper = 'A4';
$dompdf->load_html(utf8_decode($content_for_layout), Configure::read('App.encoding'));
$dompdf->render();
/*
$output = $dompdf->output();
$file_to_save = $this->webroot . 'files' . DS . 'pdf' . DS .'1.pdf';
file_put_contents($file_to_save, $output);

 * 
 */
 echo $dompdf->output();
