<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * OrdemServicoVolumeCarregamento Entity
 *
 * @property int $id
 * @property int $empresa_id
 * @property int $formacao_carga_volume_id
 * @property int $ordem_servico_id
 *
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\FormacaoCargaVolume $formacao_carga_volume
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 */
class OrdemServicoVolumeCarregamento extends Entity
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
        
        'empresa_id' => true,
        'formacao_carga_volume_id' => true,
        'ordem_servico_id' => true,
        'empresa' => true,
        'formacao_carga_volume' => true,
        'ordem_servico' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function foiCarregado( $that )
    {
        $aData         = $that->request->getData();
        $sCodigoBarras = $aData['sCodebar'];
        $iOSID         = $aData['iOSID'];
        
        $aVolumesCarregados = OrdemServicoVolumeCarregamento::getVolumesCarregados($iOSID);

        return in_array($sCodigoBarras, $aVolumesCarregados['codigo_barras']);
    }

    public static function getFormacaoCargasArrays($sFormacaoCargasIDs)
    {
        $aFormacaoCargas = [];
        $sFormacaoCargasIDs = str_replace(' ', '', $sFormacaoCargasIDs);
        
        if (!$sFormacaoCargasIDs)
            return $aFormacaoCargas;

        $aFormacaoCargasIDs = explode(',', $sFormacaoCargasIDs);

        $aFormacaoCargasQuery = TableRegistry::get('FormacaoCargas')->find()
            ->contain([
                'FormacaoCargaVolumes'
            ]) 
            ->where(['FormacaoCargas.id IN' => $aFormacaoCargasIDs])
            ->toArray();
            
        foreach ($aFormacaoCargasQuery as $oFormacaoCarga) {
            $aFormacaoCargas[ $oFormacaoCarga->id ]['itens'] = $oFormacaoCarga->formacao_carga_volumes;
            $aFormacaoCargas[ $oFormacaoCarga->id ]['formacao_dados'] = $oFormacaoCarga;
        }
        
        return $aFormacaoCargas;
    }

    public static function getVolumesCarregados($iOSID)
    {
        $aVolumes      = [];
        $aCodigoBarras = [];

        $aVolumesCarregados = TableRegistry::get('OrdemServicoVolumeCarregamentos')->find()
            ->contain([
                'FormacaoCargaVolumes'
            ])
            ->where([
                'OrdemServicoVolumeCarregamentos.ordem_servico_id' => $iOSID
            ])
            ->toArray();

        foreach ($aVolumesCarregados as $oVolumeCarregado) {
            $sCodigoBarras = $oVolumeCarregado->formacao_carga_volume->codigo_barras;
            $aVolumes[ $sCodigoBarras ] = true;
            $aCodigoBarras[] = $sCodigoBarras;
        }
        
        return [
            'volumes'       => $aVolumes,
            'codigo_barras' => $aCodigoBarras
        ];
    }
}
