<?php
namespace App\Model\Entity;

use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use Cake\ORM\Entity;

class Avaria extends Entity
{
    protected $_accessible = [
        'codigo' => true,
        'descricao' => true,
        'termo_avarias' => true
    ];

    public static function getArrayContainersAvarias($aDadosVistoria)
    {
        $aContainers = [];
        foreach ($aDadosVistoria['oVistoria']->vistoria_itens as $oVistoriaItem) {
            $aContainers[$oVistoriaItem->id] = $oVistoriaItem->container_id;
        }

        $aAvariasOptions = [];
        foreach ($aContainers as $key => $value) {
            $aAvariasOptions[$value . '_' . $key] = LgDbUtil::getFind('Avarias')
                ->contain(['AvariaRespostas'])
                ->where(['Avarias.vistoria_tipo_carga_id' => EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Container')])
                ->toArray();
        }

        return $aAvariasOptions;
    }

    public static function getArrayCargaGeralAvarias()
    {
        $aAvarias = LgDbUtil::getFind('Avarias')
            ->where(['Avarias.vistoria_tipo_carga_id' => EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Carga Geral')])
            ->toArray();

        $aAvariasOptions = [];
        foreach ($aAvarias as $aAvaria) {
            $aAvariasOptions[$aAvaria->id] = $aAvaria->codigo . ' - ' . $aAvaria->descricao;
        }

        return $aAvariasOptions;
    }

}
