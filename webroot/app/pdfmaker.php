<?php

class pdfmaker {

    public $data = [];

    public $mpdf = null;

    // formatadores
    public function f_f($s) {
        return ''.floatval($s);
    }
    public function f_d1($s) {
        return number_format($s, 2, ',', '');
    }

    public function f_d2($s) {
        return number_format($s, 2, ',', '');
    }

    public function f_d3($s) {
        return number_format($s, 3, ',', '');
    }
    public function f_d4($s) {
        return number_format($s, 3, ',', '');
    }

    public function f_m($s) {
        return number_format($s, 2, ',', '.');
    }

    public function f_d($s) {
        return implode('/', array_reverse(explode('-', substr($s, 0, 10))));
    }

    public function f_dt($s) {
        $p = preg_split('/[\-\s\:\.]/', $s);
        return $p[2] . '/' . $p[1] . '/' . $p[0] . ' ' . $p[3] . ':' . $p[4] . ':' . $p[5];
    }


    public function __get($columnName)
    {
        if (array_key_exists($columnName, $this->data)) {
            return $this->data[$columnName];

        } else {
            error_log('Data not found: '. $columnName);
            return '<span style="color:red">?' . $columnName . '?</span>';
        }
    }

    public function gen($layout, $params)
    {
        include_once "pdfmaker/$layout/datasource.php";
        $reportClassName = $layout.'DataSource';
        $ds = new $reportClassName();
		$this->params = $params;
        $this->data = $ds->getData($params);
        $this->data['_CONFIG'] = include 'config.php';

        ob_start();
        include "pdfmaker/$layout/index.phtml";
        $html = ob_get_clean();

        require_once 'mPDF/vendor/autoload.php';

        if (is_readable("pdfmaker/$layout/mpdf.config.php"))
            $this->mpdf = include "pdfmaker/$layout/mpdf.config.php";
        else
            $this->mpdf = new mPDF('c', 'A4', '', '', 10, 10, 36, 15, 10, 10, 'P');
        $this->mpdf->WriteHTML($html);
    }

    public function savePDF($filename)
    {
        $this->mpdf->Output($filename);
    }

    public function outputPDF()
    {
        $this->mpdf->Output();
    }

    public function output()
    {
        return $this->mpdf->Output('', 'S');
    }

    public static function make($layout, $params, $filename = '') {
        $r = new pdfmaker();
        $r->gen($layout, $params);
        if ($filename)
            $r->savePDF($filename);
        else
            return $r->output();
    }
}
