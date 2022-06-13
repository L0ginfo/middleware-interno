<?php

class pdf003DataSource {

    public $description = '';

    public function getData($params = [])
    {
        $data = [];

        $data = dbportal::fetch('select * from protocolo_capa where portal_agendamento_id = ?', [ $params['portal_agendamento_id']]);
		$data['PORTAL_AGENDAMENTO_ID'] = $params['portal_agendamento_id'];
// error_log(print_r($data, true));
//echo $data['TIPO_OPERACAO']; die();
        if (trim($data['TIPO_OPERACAO']) == 'Descarga') {
            $data['itens'] = dbportal::fetchAll('select * from protocolo_itens_descarga where portal_agendamento_id = ?', [ $params['portal_agendamento_id']]);
//var_dump ('select * from protocolo_itens_descarga where portal_agendamento_id = ?', [ $params['portal_agendamento_id']]);die();

            // $data['itens'] = [[], [], [], [], [], [], []];

// error_log(print_r($data['itens'], true));
        } 

        return $data;
    }
}
