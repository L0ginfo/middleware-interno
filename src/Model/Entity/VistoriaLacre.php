<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

/**
 * VistoriaLacre Entity
 *
 * @property int $id
 * @property string $lacre_numero
 * @property int $lacre_tipo_id
 * @property int $vistoria_id
 * @property int|null $vistoria_item_id
 *
 * @property \App\Model\Entity\LacreTipo $lacre_tipo
 * @property \App\Model\Entity\Vistoria $vistoria
 * @property \App\Model\Entity\VistoriaItem $vistoria_item
 */
class VistoriaLacre extends Entity
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
        
        'lacre_numero' => true,
        'lacre_tipo_id' => true,
        'vistoria_id' => true,
        'vistoria_item_id' => true,
        'lacre_tipo' => true,
        'vistoria' => true,
        'vistoria_item' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getLacres($iVistoriaId, $iVistoriaItemId = null)
    {
        $aLacres = [];
        $oVistoria = LgDbUtil::getFind('Vistorias')
            ->contain(['VistoriaItens'])
            ->where(['Vistorias.id' => $iVistoriaId])
            ->first();

        $iContainerId = array_reduce($oVistoria->vistoria_itens, function($carry, $oVistoriaItem) use ($iVistoriaItemId) {
            if ($oVistoriaItem->id == $iVistoriaItemId)
                $carry = $oVistoriaItem->container_id;
            return $carry;
        }, null);

        if ($oVistoria->ordem_servico_id) {
            $aLacres = OrdemServicoLacre::getLacresByOs($oVistoria->ordem_servico_id, $iContainerId);
        } elseif ($oVistoria->resv_id) {
            $aLacres = self::getLacresByResv($oVistoria->resv_id, $iContainerId);
        } else {
            $aLacres = self::getLacresByProgramacao($oVistoria->programacao_id, $iContainerId);
        }

        return $aLacres;
    }

    public static function getLacresByResv($iResvId, $iContainerId = null)
    {
        $oResv = LgDbUtil::getFind('Resvs')
            ->contain([
                'ResvsDocumentosTransportes' => [
                    'DocumentosTransportes' => [
                        'DocumentoTransporteLacres'
                    ]
                ],
                'ResvsContainers' => [
                    'ResvContainerLacres'
                ]
            ])
            ->where(['Resvs.id' => $iResvId])
            ->first();

        $aContainerLacres = [];
        foreach ($oResv->resvs_containers as $oResvContainer) {
            if ($iContainerId && $iContainerId != $oResvContainer->container_id)
                continue;
            foreach ($oResvContainer->resv_container_lacres as $oLacre) {
                $aContainerLacres[$oLacre->lacre_tipo_id][] = $oLacre->lacre_numero;
            }
        }

        $aLacresDocs = [];
        foreach ($oResv->resvs_documentos_transportes as $oResvDocTransp) {
            foreach ($oResvDocTransp->documentos_transporte->documento_transporte_lacres as $oLacre) {
                $aLacresDocs[$oLacre->lacre_tipo_id][] = $oLacre->descricao;
            }
        }

        return [
            'aContainerLacres' => $aContainerLacres,
            'aDocLacres' => $aLacresDocs
        ];
    }

    public static function getLacresByProgramacao($iProgramacaoId, $iContainerId = null)
    {
        $oProgramacao = LgDbUtil::getFind('Programacoes')
            ->contain([
                'ProgramacaoDocumentoTransportes' => [
                    'DocumentosTransportes' => [
                        'DocumentoTransporteLacres'
                    ]
                ],
                'ProgramacaoContainers' => [
                    'ProgramacaoContainerLacres'
                ]
            ])
            ->where(['Programacoes.id' => $iProgramacaoId])
            ->first();

        if (isset($oProgramacao) && $oProgramacao->resv_id)
            return self::getLacresByResv($oProgramacao->resv_id);

        $aContainerLacres = [];
        foreach ($oProgramacao->programacao_containers as $oProgramacaoContainer) {
            if ($iContainerId && $iContainerId != $oProgramacaoContainer->container_id)
                continue;
            foreach ($oProgramacaoContainer->programacao_container_lacres as $oLacre) {
                $aContainerLacres[$oLacre->lacre_tipo_id][] = $oLacre->lacre_numero;
            }
        }

        $aLacresDocs = [];
        foreach ($oProgramacao->programacao_documento_transportes as $oProgramacaoDocTransp) {
            foreach ($oProgramacaoDocTransp->documentos_transporte->documento_transporte_lacres as $oLacre) {
                $aLacresDocs[$oLacre->lacre_tipo_id][] = $oLacre->descricao;
            }
        }

        return [
            'aContainerLacres' => $aContainerLacres,
            'aDocLacres' => $aLacresDocs
        ];
    }

    public static function validateLacre($sLacre, $iTipoId, $iVistoriaId, $iVistoriaItemId = null)
    {
        $oResponse = new ResponseUtil();
        if (!$sLacre || !$iTipoId || !$iVistoriaId)
            return $oResponse->setMessage('Faltam parâmetros para salvar o lacre');

        $aLacres = self::getLacres($iVistoriaId, $iVistoriaItemId);
        $aContainerLacres = $aLacres['aContainerLacres'];
        $aLacresDocs = $aLacres['aDocLacres'];

        if ((isset($aContainerLacres[$iTipoId]) && in_array($sLacre, $aContainerLacres[$iTipoId]))
            || (isset($aLacresDocs[$iTipoId]) && in_array($sLacre, $aLacresDocs[$iTipoId]))) {
                return $oResponse->setStatus(200)
                    ->setMessage('Lacre validado com sucesso.');
            }

        return $oResponse
            ->setStatus(406)
            ->setMessage('Lacre não encontrado.');
    }
}
