<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;

/**
 * ResvsDocumentosTransporte Entity
 *
 * @property int $id
 * @property int $resv_id
 * @property int $documento_transporte_id
 *
 * @property \App\Model\Entity\Resv $resv
 * @property \App\Model\Entity\DocumentosTransporte $documentos_transporte
 */
class ResvsDocumentosTransporte extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     * 
     *   'resv_id' => true,
     *   'documento_transporte_id' => true,
     *   'resv' => true,
     *   'documentos_transporte' => true
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getAllDocumentoTransportes($iOSID)
    {
        $oOrdemServico = LgDbUtil::getByID('OrdemServicos', $iOSID);

        $aDocumentoTransportes = [];

        $aResvDocumentoTransportes = LgDbUtil::getFind('ResvsDocumentosTransportes')
            ->contain('DocumentosTransportes')
            ->where([
                'ResvsDocumentosTransportes.resv_id' => $oOrdemServico->resv_id
            ])->toArray();

        foreach ($aResvDocumentoTransportes as $oResvDocumentoTransporte) {
            $aDocumentoTransportes[$oResvDocumentoTransporte->documento_transporte_id] = $oResvDocumentoTransporte->documentos_transporte->numero;
        }

        return $aDocumentoTransportes;
    }
    
    public static function getPesagemResvsDocumentosTransportes($iResvID)
    {
        $aResvsDocumentosTransportes = LgDbUtil::getFind('ResvsDocumentosTransportes')->contain([
            'DocumentosTransportes' => [
                'DocumentosMercadoriasMany' => [
                    'Clientes',
                    'DocumentosMercadoriasItens' => [
                        'Produtos'
                    ]
                ]
            ]
        ])->where(['ResvsDocumentosTransportes.resv_id' => $iResvID])->toArray();
        return $aResvsDocumentosTransportes;
    }
}
