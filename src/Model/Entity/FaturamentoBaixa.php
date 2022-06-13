<?php
namespace App\Model\Entity;

use App\Util\DateUtil;
use App\Util\DoubleUtil;
use App\Util\LgDbUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * FaturamentoBaixa Entity
 *
 * @property int $id
 * @property int $sequencia_baixa
 * @property \Cake\I18n\Time $data_baixa
 * @property string $agencia
 * @property string $conta
 * @property string $valor_baixa
 * @property int $tipo_pagamento_id
 * @property int $banco_id
 * @property int $faturamento_armazenagem_id
 *
 * @property \App\Model\Entity\TipoPagamento $tipo_pagamento
 * @property \App\Model\Entity\Banco $banco
 * @property \App\Model\Entity\FaturamentoArmazenagem $faturamento_armazenagem
 */
class FaturamentoBaixa extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'id' => false,
        '*' => true,
    ];
        
    public static function setData($entity, $aData, $sTipo = 'manual', $bObrigaUsoArm = true, $iFaturamentoID = null){
        $aData['faturamento_id']    = $iFaturamentoID ?:$aData['faturamento_id'];
        $aData['empresa_id']        = Empresa::getEmpresaAtual() ?: null;
        $aData['data_baixa']        = DateUtil::dateTimeToDB($aData['data_baixa']);
        $aData['valor_baixa']       = DoubleUtil::toDBUnformat($aData['valor_baixa']);
        $aData['tipo_baixa']        = $sTipo;

        $oBanco = LgDbUtil::getFirst('Bancos', [
            'id' => $aData['banco_id']
        ]);

        $aData['agencia'] = $oBanco->agencia;
        $aData['conta'] = $oBanco->conta;

        if(!$bObrigaUsoArm) {

            $oFaturamento = LgDbUtil::getByID('Faturamentos', $aData['faturamento_id']);

            $iCountFaturamentoBaixas = LgDbUtil::getFind('FaturamentoBaixas')
                ->where(['faturamento_id' => $oFaturamento->id])
                ->count();

            $aData['sequencia_baixa']  = $iCountFaturamentoBaixas + 1;

            return LgDbUtil::get('FaturamentoBaixas')->patchEntity($entity, $aData);
        }

        $oFaturamentoArmazenagem = LgDbUtil::getByID('FaturamentoArmazenagens', $aData['faturamento_armazenagem_id']);
        $iCountFaturamentoBaixas = LgDbUtil::getFind('FaturamentoBaixas')
        ->where(['faturamento_id' => $oFaturamentoArmazenagem->faturamento_id])
        ->count();
        
        $aData['sequencia_baixa']    = $iCountFaturamentoBaixas + 1;
        $aData['faturamento_id']     = $oFaturamentoArmazenagem->faturamento_id;
        return LgDbUtil::get('FaturamentoBaixas')->patchEntity($entity, $aData);
    }

    public function setSequencia($sequencia_baixa){
        $this->sequencia_baixa = $sequencia_baixa;
    }

    public function setSequenciaByFaturamento($faturamento_armazenagem){
        $entities = isset($faturamento_armazenagem->faturamento_baixas) ? $faturamento_armazenagem->faturamento_baixas : [];
        $this->sequencia_baixa = empty($entities) ? 1 : $entities[count($entities)]->sequencia_baixa+1;
    }

    public function teveAlgumaBaixa( $that, $iFaturamentoID )
    {
        $oBaixaViaRetorno = LgDbUtil::get('FaturamentoBaixas')->find()
            ->where([ 'FaturamentoBaixas.faturamento_id' => $iFaturamentoID])
            ->order(['data_baixa DESC'])
            ->first();
            
        $oBaixaViaManual = LgDbUtil::get('FaturamentoBaixas')->find()
            ->contain('FaturamentoArmazenagens')
            ->where([ 'FaturamentoArmazenagens.faturamento_id' => $iFaturamentoID])
            ->order(['data_baixa DESC'])
            ->first();

        if ($oBaixaViaManual || $oBaixaViaRetorno)
            return [
                'oBaixaViaManual'  => $oBaixaViaManual,
                'oBaixaViaRetorno' => $oBaixaViaRetorno,
            ];

        return false;
    }
    
    public function getBaixaSemArm( $that, $iFaturamentoID )
    {
        $oBaixa = $that->FaturamentoBaixas->find()
            ->where([ 
                'FaturamentoBaixas.faturamento_id' => $iFaturamentoID,
                'valor_sem_arm_encontrada' => 1,
                'valor_sem_arm_encontrada IS NOT NULL'
            ])
            ->order(['data_baixa DESC'])
            ->first();

        return $oBaixa;
    }

    public static function getFilters(){

        $aTiposFaturamentos = LgDbUtil::get('TiposFaturamentos')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] );
        
        return [
            [
                'name'  => 'numero',
                'divClass' => 'col-lg-3',
                'label' => 'Numero Faturamento',
                'table' => [
                    'className' => 'Faturamentos',
                    'field'     => 'numero_faturamento',
                    'operacao'  => 'contem'
                ]
            ],

            [
                'name'  => 'ni',
                'divClass' => 'col-lg-3',
                'label' => 'Numero Primário DAI',
                'table' => [
                    'className' => 'Faturamentos',
                    'field'     => 'count_dai_primario',
                    'operacao'  => 'contem'
                ]
            ],

            [
                'name'  => 'ne',
                'divClass' => 'col-lg-3',
                'label' => 'Numero Primário DAE',
                'table' => [
                    'className' => 'Faturamentos',
                    'field'     => 'count_dae_primario',
                    'operacao'  => 'contem'
                ]
            ],

            [
                'name'  => 'nsc',
                'divClass' => 'col-lg-3',
                'label' => 'Numero Primário DAPE sc',
                'table' => [
                    'className' => 'Faturamentos',
                    'field'     => 'count_dapesc_primario',
                    'operacao'  => 'contem'
                ]
            ],

            [
                'name'  => 'ncc',
                'divClass' => 'col-lg-3',
                'label' => 'Numero Primário DAPE cc',
                'table' => [
                    'className' => 'Faturamentos',
                    'field'     => 'count_dape_primario',
                    'operacao'  => 'contem'
                ]
            ],

            [
                'name'  => 'documento',
                'divClass' => 'col-lg-3',
                'label' => 'Liberação Documental',
                'table' => [
                    'className' => 'LeftLiberacoesDocumentais',
                    'field'     => 'numero',
                    'operacao'  => 'contem'
                ]
            ],
            
            [
                'name'  => 'cliente',
                'divClass' => 'col-lg-3',
                'label' => 'Cliente',
                'table' => [
                    'className' => 'Clientes',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
    
            [
                'name'  => 'data_hora_inicio',
                'divClass' => 'col-lg-2',
                'label' => 'Data nicio',
                'table' => [
                    'className' => 'Faturamentos',
                    'field'     => 'data_hora_emissao',
                    'operacao'  => 'maior ou igual',
                    'type'      => 'date'
                ]
            ],
            [
                'name'  => 'data_hora_fim',
                'divClass' => 'col-lg-2',
                'label' => 'Data Entrada',
                'table' => [
                    'className' => 'Faturamentos',
                    'field'     => 'data_hora_emissao',
                    'operacao'  => 'menor ou igual',
                    'type'      => 'date'
                ]
            ],
            [
                'name'  => 'tipo_faturamento',
                'divClass' => 'col-lg-2',
                'label' => 'TiposFaturamentos',
                'table' => [
                    'className' => 'TiposFaturamentos',
                    'field'     => 'id',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'   => $aTiposFaturamentos
                ]
            ]
        ];

    }
}
