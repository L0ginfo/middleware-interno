<?php
namespace App\Model\Entity;

use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * FormacaoCargaVolume Entity
 *
 * @property int $id
 * @property string $codigo_barras
 * @property int $formacao_carga_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\FormacaoCarga $formacao_carga
 */
class FormacaoCargaVolume extends Entity
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
        
        'codigo_barras' => true,
        'formacao_carga_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'formacao_carga' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function reorderSequencias($iFormacaoCargaID)
    {
        $aVolumes = TableRegistry::get('FormacaoCargaVolumes')->find()
            ->where(['formacao_carga_id' => $iFormacaoCargaID])
            ->order(['id' => 'ASC'])
            ->toArray();

        foreach ($aVolumes as $iKey => $oVolume) {
            $oVolume->sequencia = $iKey + 1;
            TableRegistry::get('FormacaoCargaVolumes')->save($oVolume);
        }
    }

    public static function getCodigoBarras()
    {
        $iLastIDMoreOne = EntityUtil::getLastId('FormacaoCargaVolumes') + 1;

        return str_pad($iLastIDMoreOne, 15, '0', STR_PAD_LEFT);
    }

    public static function findByCodebar($sCodigoBarras) 
    {
        $aFormacaoCargaVolumeItens = TableRegistry::get('FormacaoCargaVolumeItens')->find()
            ->contain([
                'FormacaoCargaVolumes',
                'OrdemServicoItemSeparacoes'
            ])
            ->where([
                'FormacaoCargaVolumes.codigo_barras' => $sCodigoBarras, 
                //'FormacaoCargaVolumes.id' => ((int) $sCodigoBarras),
                'OrdemServicoItemSeparacoes.endereco_separacao_id IS NOT NULL',
                'FormacaoCargaVolumeItens.quantidade > 0',
                'OrdemServicoItemSeparacoes.qtde_saldo > 0',
            ])
            ->toArray();

        return $aFormacaoCargaVolumeItens;
    }

    public static function setEnviado($iFormacaoCargaId)
    {
        $aFormacaoCargaVolumes = LgDbUtil::getFind('FormacaoCargaVolumes')
            ->where(['formacao_carga_id' => $iFormacaoCargaId])
            ->toArray();

        if (!$aFormacaoCargaVolumes)
            return;

        foreach ($aFormacaoCargaVolumes as $oFormacaoCargaVolume) {
            $oFormacaoCargaVolume->enviado_integracao = 1;
            LgDbUtil::get('FormacaoCargaVolumes')->save($oFormacaoCargaVolume);
        }
    }
}
