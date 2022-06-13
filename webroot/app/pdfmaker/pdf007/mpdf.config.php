<?php 
$mpdf = new mPDF('c', [210, 290], 0, 'Helvetica', 10, 10, 10, 10, 0, 0, 'P');
$mpdf->shrink_tables_to_fit = 0;
return $mpdf;
