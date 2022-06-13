<?php
namespace App\Model\Entity;

use App\Util\ResponseUtil;
use Cake\ORM\Entity;
use App\Util\LgDbUtil;

class ControleEspecifico extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getParamLabelControleEspecificos()
    {
        $oResponse = new ResponseUtil();

        $oParamn = ParametroGeral::getParameterByUniqueName('PARAM_LABEL_CONTROLE_ESPECIFICO');
        if (!$oParamn)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Não foi encontrado o Parametro Geral para exibir o label do campo Controle Específicos!');

        return $oResponse
            ->setStatus(200)
            ->setDataExtra($oParamn);
    }
    
    public static function getFilters()
    {        
        return [
            [
                'name'  => 'id',
                'divClass' => 'col-lg-3',
                'label' => 'ID',
                'table' => [
                    'className' => 'ControleEspecificos',
                    'field'     => 'id',
                    'operacao'  => 'igual'
                ]
            ],
            [
                'name'  => 'codigo',
                'divClass' => 'col-lg-3',
                'label' => 'Código',
                'table' => [
                    'className' => 'ControleEspecificos',
                    'field'     => 'codigo',
                    'operacao'  => 'contem'
                ]
            ],

            [
                'name'  => 'descricao',
                'divClass' => 'col-lg-3',
                'label' => 'Descrição',
                'table' => [
                    'className' => 'ControleEspecificos',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ]
        ];
    }
}
