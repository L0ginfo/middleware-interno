<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use App\Model\Entity\SeparacaoSituacao;

/**
 * FormacaoCarga Entity
 *
 * @property int $id
 * @property int|null $transportadora_id
 * @property int|null $veiculo_id
 * @property int|null $codigo
 * @property int $is_criado_resv
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\Transportadora $transportadora
 * @property \App\Model\Entity\Veiculo $veiculo
 * @property \App\Model\Entity\FormacaoCargaVeiculo[] $formacao_carga_veiculos
 * @property \App\Model\Entity\FormacaoCargaVolumeItem[] $formacao_carga_volume_itens
 * @property \App\Model\Entity\FormacaoCargaVolume[] $formacao_carga_volumes
 */
class FormacaoCarga extends Entity
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
     /* Default fields
        
        'transportadora_id' => true,
        'veiculo_id' => true,
        'codigo' => true,
        'is_criado_resv' => true,
        'created_at' => true,
        'updated_at' => true,
        'transportadora' => true,
        'veiculo' => true,
        'formacao_carga_veiculos' => true,
        'formacao_carga_volume_itens' => true,
        'formacao_carga_volumes' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function setFormacaoPedidosNFs($aRelationPedidoNF, $iFormacaoCargaID)
    {
        foreach ($aRelationPedidoNF as $iSeparacaoCargaID => $sNumeroNF) {
            $sNumeroNF = trim($sNumeroNF);
            $oFormacaoPedidoNF = TableRegistry::get('FormacaoCargaNfPedidos')->find()
                ->where([
                    'formacao_carga_id' => $iFormacaoCargaID,
                    'separacao_carga_id' => $iSeparacaoCargaID
                ])
                ->first();

            if (!$sNumeroNF) {
                TableRegistry::get('FormacaoCargaNfPedidos')->deleteAll([
                    [
                        'formacao_carga_id' => $iFormacaoCargaID,
                        'separacao_carga_id' => $iSeparacaoCargaID
                    ]
                ]);

                SeparacaoSituacao::setSituacao(
                    [$iSeparacaoCargaID], 
                    'Separado'
                );

                continue;
            }

            SeparacaoSituacao::setSituacao(
                [$iSeparacaoCargaID], 
                'Faturado'
            );

            if (!$oFormacaoPedidoNF) 
                $oFormacaoPedidoNF = TableRegistry::get('FormacaoCargaNfPedidos')->newEntity([
                    'separacao_carga_id' => $iSeparacaoCargaID,
                    'formacao_carga_id' => $iFormacaoCargaID,
                ]);

            $oFormacaoPedidoNF->numero_nf = $sNumeroNF;

            TableRegistry::get('FormacaoCargaNfPedidos')->save($oFormacaoPedidoNF);
        }
    }

    public static function getFormacaoPedidosNFs($iFormacaoCargaID)
    {
        $aFormacaoCargaVolumeItens = TableRegistry::get('FormacaoCargaVolumeItens')->find()
            ->contain([
                'FormacaoCargaVolumes',
                'OrdemServicoItemSeparacoes' => [
                    'SeparacaoCargaItens' => [
                        'SeparacaoCargas' => ['Empresas']
                    ]
                ]
            ])
            ->where(['FormacaoCargaVolumes.formacao_carga_id' => $iFormacaoCargaID])
            ->toArray();

        $aSeparacaoCargaIDsAgroup = [];

        foreach ($aFormacaoCargaVolumeItens as $oFormacaoCargaVolumeItem) {
            $oSeparacaoCarga = $oFormacaoCargaVolumeItem->ordem_servico_item_separacao->separacao_carga_item->separacao_carga;
            
            $aSeparacaoCargaIDsAgroup[ $oSeparacaoCarga->id ] = [
                'numero_nf' => '',
                'separacao_carga_id' => $oSeparacaoCarga->id,
                'separacao_carga_numero' => $oSeparacaoCarga->numero_pedido,
                'cliente' => $oSeparacaoCarga->empresa->descricao
            ];
        }

        if (!$aSeparacaoCargaIDsAgroup)
            return [];

        $aQueryFormacaoPedidosNFs = TableRegistry::get('FormacaoCargaNfPedidos')->find('list', [
            'keyField' => 'separacao_carga_id',
            'valueField' => 'numero_nf'
        ])
            ->where([
                'FormacaoCargaNfPedidos.formacao_carga_id' => $iFormacaoCargaID
            ])
            ->toArray();


        foreach ($aSeparacaoCargaIDsAgroup as $iSeparacaoCargaID => $aData) {
            if (array_key_exists($iSeparacaoCargaID, $aQueryFormacaoPedidosNFs)) {
                $aSeparacaoCargaIDsAgroup[$iSeparacaoCargaID]['numero_nf'] = $aQueryFormacaoPedidosNFs[$iSeparacaoCargaID];
            }
        }

        return $aSeparacaoCargaIDsAgroup;
    }

    public static function getFilters() 
    {
        return [
            [
                'name'  => 'numero_pedido',
                'divClass' => 'col-lg-2',
                'label' => 'Nº Pedido',
                'table' => [
                    'className' => 'FormacaoCargaNfPedidosInner.SeparacaoCargas',
                    'field'     => 'numero_pedido',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'numero_nf',
                'divClass' => 'col-lg-2',
                'label' => 'Nº NF',
                'table' => [
                    'className' => 'FormacaoCargas.FormacaoCargaNfPedidosInner',
                    'field'     => 'numero_nf',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'situacao',
                'divClass' => 'col-lg-2',
                'label' => 'Situação',
                'table' => [
                    'className' => 'FormacaoCargaSituacoes',
                    'field'     => 'descricao',
                    'operacao'  => 'contem',
                    'typeVar'   => 'string'
                ]
            ],
            [
                'name'  => 'veiculo',
                'divClass' => 'col-lg-2',
                'label' => 'Veículo',
                'table' => [
                    'className' => 'FormacaoCargas.Veiculos',
                    'field'     => 'descricao',
                    'operacao'  => 'contem',
                    'typeVar'   => 'string'
                ]
            ],
            [
                'name'  => 'transportadora',
                'divClass' => 'col-lg-4',
                'label' => 'Transportadora',
                'table' => [
                    'className' => 'FormacaoCargas.Transportadoras',
                    'field'     => 'razao_social',
                    'operacao'  => 'contem',
                    'typeVar'   => 'string'
                ]
            ],
            [
                'name'  => 'cliente',
                'divClass' => 'col-lg-4',
                'label' => 'Cliente',
                'table' => [
                    'className' => 'FormacaoCargaNfPedidosInner.SeparacaoCargas.Empresas',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'cidade',
                'divClass' => 'col-lg-3',
                'label' => 'Cidade',
                'table' => [
                    'className' => 'FormacaoCargas',
                    'field'     => 'cidade',
                    'operacao'  => 'contem',
                    'typeVar'   => 'string'
                ]
            ],
            [
                'name'  => 'estado',
                'divClass' => 'col-lg-2',
                'label' => 'UF',
                'table' => [
                    'className' => 'FormacaoCargas',
                    'field'     => 'cidade',
                    'operacao'  => 'contem',
                    'typeVar'   => 'string'
                ]
            ]
        ];
    }

    public static function finalizarFormacoes($oOrdemServico)
    {
        $aFormacaoCargaIDs = [];
        $aResvsFormacaoCargas = TableRegistry::getTableLocator()->get('ResvsFormacaoCargas')->find()
            ->where([
                'resv_id' => $oOrdemServico->resv_id
            ])->toArray();

        foreach ($aResvsFormacaoCargas as $oResvsFormacaoCarga) {
            $aFormacaoCargaIDs[] = $oResvsFormacaoCarga->formacao_carga_id;
        }

        if (!$aFormacaoCargaIDs)
            return false;

        TableRegistry::getTableLocator()->get('FormacaoCargas')->updateAll(
            [
                'formacao_carga_situacao_id' => 3
            ],
            [
                'id IN' => $aFormacaoCargaIDs
            ]
        );
    }
}
