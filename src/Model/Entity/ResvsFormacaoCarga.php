<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * ResvsFormacaoCarga Entity
 *
 * @property int $id
 * @property int $resv_id
 * @property int $formacao_carga_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\Resv $resv
 * @property \App\Model\Entity\FormacaoCarga $formacao_carga
 */
class ResvsFormacaoCarga extends Entity
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
        
        'resv_id' => true,
        'formacao_carga_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'resv' => true,
        'formacao_carga' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getOSPendentesFormacaoCargas($iOSID = null) 
    {
        $oResvsFormacaoCargas = TableRegistry::get('ResvsFormacaoCargas')->find();

        $oFormacaoCargasIDs__custom = $oResvsFormacaoCargas->newExpr()
            ->add(
                LgDbUtil::setConcatGroupByDb('FormacaoCargas.id')
            );

        $oIDsLD__custom = $oResvsFormacaoCargas->newExpr()
            ->add(
                LgDbUtil::setConcatGroupByDb('FormacaoCargas.id')
            );

        $oSituacoes__custom = $oResvsFormacaoCargas->newExpr()
            ->addCase(
                [
                    $oResvsFormacaoCargas->newExpr()->add(
                        '(data_hora_fim IS NULL)'
                    )
                ],
                ['aguardando_carga', 'finalizado'],
                ['string', 'string']
            );

        $oResvsFormacaoCargas
            ->select([
                'OrdemServicos.id',
                'veiculo_identificacao' => 'Veiculos.veiculo_identificacao',
                'num_doc'               => 'FormacaoCargas.id',
                'documentos_numeros'    => $oFormacaoCargasIDs__custom,
                'ids_registry_fc'       => $oIDsLD__custom,
                'situacao'              => $oSituacoes__custom,
                'class_name'            => "'Formações de Cargas'"
            ])
            ->contain([
                'FormacaoCargas',
                'Resvs',
                'Resvs.Veiculos',
                'OrdemServicos'
            ])
            ->where([
                'OrdemServicos.ordem_servico_tipo_id = 2',
                'OrdemServicos.data_hora_fim IS NULL',
                'OrdemServicos.resv_id IS NOT NULL',
            ] +
                ($iOSID 
                    ? ['OrdemServicos.id' => $iOSID]
                    : [] 
                ) 
            )
            ->group([
                'OrdemServicos.id', 
                'Veiculos.veiculo_identificacao',
                'FormacaoCargas.id',
                'OrdemServicos.data_hora_fim'
            ])
            ->toArray();
            
      return $oResvsFormacaoCargas;

    }
}
