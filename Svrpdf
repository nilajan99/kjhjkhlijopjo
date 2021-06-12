<!-- https://github.com/dompdf/dompdf
https://mpdf.github.io/installation-setup/installation-v7-x.html -->

<?php

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML('<h1>Hello world!</h1>');
//$mpdf->Output();
$file_name = './pdf/'.date('Y').'.pdf';
$mpdf->Output($file_name, 'F');
