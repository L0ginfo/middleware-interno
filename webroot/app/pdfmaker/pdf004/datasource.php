<?php

class pdf004DataSource {

    public $description = '';

    public function getData($params = [])
    {
        $data = [];

        $data = dbportal::fetch('select * from protocolo_capa where portal_agendamento_id = ?', [ $params['portal_agendamento_id']]);
		$data['PORTAL_AGENDAMENTO_ID'] = $params['portal_agendamento_id'];
// error_log(print_r($data, true));
//echo $data['TIPO_OPERACAO']; die();
   			$data['itens'] = [];
             $data['itens'] = dbsara::fetchAll('select * from v_loginfo_itens_agendados where qt_carregada > 0 and portal_agendamento_id = ?', [ $params['portal_agendamento_id']]);


$clientes=[];
foreach ($data['itens'] as $i)
{
$clientes[] = $i['NOME_CLIENTE'];
}
$data['clientes'] =  array_unique($clientes); ;
//var_dump( $clientes);die();


        return $data;
    }
}
