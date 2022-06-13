<?php
namespace App\Model\Entity;

use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

/**
 * OrdemServicoLacre Entity
 *
 * @property int $id
 * @property int $ordem_servico_id
 * @property string $descricao
 * @property int $lacre_tipo_id
 *
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 * @property \App\Model\Entity\LacreTipo $lacre_tipo
 */
class OrdemServicoLacre extends Entity
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
        
        'ordem_servico_id' => true,
        'descricao' => true,
        'lacre_tipo_id' => true,
        'ordem_servico' => true,
        'lacre_tipo' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function validateLacre($sLacre, $iTipoId, $iOsId)
    {
        $oResponse = new ResponseUtil();
        if (!$sLacre || !$iTipoId || !$iOsId)
            return $oResponse->setMessage('Faltam parâmetros para salvar o lacre');

        $aContainerLacres = self::getLacresByOs($iOsId)['aContainerLacres'];
        $aLacresDocs = self::getLacresByOs($iOsId)['aDocLacres'];

        if ((isset($aContainerLacres[$iTipoId]) && in_array($sLacre, $aContainerLacres[$iTipoId]))
            || (isset($aLacresDocs[$iTipoId]) && in_array($sLacre, $aLacresDocs[$iTipoId]))) {
                return $oResponse->setStatus(200)
                    ->setMessage('Lacre validado com sucesso.');
            }

        return $oResponse
            ->setStatus(406)
            ->setMessage('Lacre não encontrado.');
    }

    public static function getLacresByOs($iOsId, $iContainerId = null)
    {
        $aResvContainers = [];

        $oOrdemServico = LgDbUtil::getFind('OrdemServicos')
            ->contain(['Resvs' => [
                'ResvsDocumentosTransportes' => [
                    'DocumentosTransportes' => [
                        'DocumentoTransporteLacres'
                    ]
                ],
                'ResvsContainers' => [
                    'ResvContainerLacres'
                ],
            ]])
            ->where(['OrdemServicos.id' => $iOsId])
            ->first();

        if (!@$oOrdemServico->resv_id) {
            $oOrdemServico = LgDbUtil::getFind('OrdemServicos')
                ->contain(['OrdemServicoItens' => [
                    'Containers'
                ]])
                ->where(['OrdemServicos.id' => $iOsId])
                ->first();

            $aResvContainers = [];
            foreach ($oOrdemServico->ordem_servico_itens as $oOrdemServicoItem) {
                $oEntradaSaidaContainer = LgDbUtil::getFind('EntradaSaidaContainers')
                        ->contain(['ResvEntrada' => [
                            'ResvsContainers' => function ($q) use($oOrdemServicoItem) {
                                    return $q->contain(['ResvContainerLacres'])->where([
                                        'ResvsContainers.container_id' => $oOrdemServicoItem->container_id,
                                        'ResvsContainers.tipo <>' => 'VAZIO',
                                    ]);
                                }
                        ]])
                        ->where(['container_id' => $oOrdemServicoItem->container_id])
                        ->last();

                $aResvContainers = @$oEntradaSaidaContainer->resv_entrada->resvs_containers[0] ? [$oEntradaSaidaContainer->resv_entrada->resvs_containers[0]] : [];
            }
        }

        $aResvContainers = $aResvContainers ?: $oOrdemServico->resv->resvs_containers;

        $aContainerLacres = [];
        foreach ($aResvContainers as $oResvContainer) {
            if ($iContainerId && $iContainerId != $oResvContainer->container_id)
                continue;
            foreach ($oResvContainer->resv_container_lacres as $oLacre) {
                $aContainerLacres[$oLacre->lacre_tipo_id][] = $oLacre->lacre_numero;
            }
        }

        $aLacresDocs = [];
        if (isset($oOrdemServico->resv->resvs_documentos_transportes))
            foreach ($oOrdemServico->resv->resvs_documentos_transportes as $oResvDocTransp) {
                foreach ($oResvDocTransp->documentos_transporte->documento_transporte_lacres as $oLacre) {
                    $aLacresDocs[$oLacre->lacre_tipo_id][] = $oLacre->descricao;
                }
            }

        return [
            'aContainerLacres' => $aContainerLacres,
            'aDocLacres' => $aLacresDocs
        ];
    }

    public static function getLacresByVistoria($iOsId)
    {
        $oOrdemServico = LgDbUtil::getFind('OrdemServicos')
            ->contain(['OrdemServicoLacres'])
            ->where(['OrdemServicos.id' => $iOsId])
            ->first();

        $aWhere = [];
        $aOrdemServicoTipos = [
            EntityUtil::getIdByParams('OrdemServicoTipos', 'descricao', 'Descarga'),
            EntityUtil::getIdByParams('OrdemServicoTipos', 'descricao', 'Carga')
        ];
        if (in_array($oOrdemServico->ordem_servico_tipo_id, $aOrdemServicoTipos)) {
            $aWhere =['Vistorias.resv_id' => $oOrdemServico->resv_id];
        } else {
            $aWhere = ['ordem_servico_id' => $iOsId];
        }

        $oVistoria = LgDbUtil::getFind('Vistorias')
            ->contain(['VistoriaLacres'])
            ->where($aWhere)
            ->first();

        if (isset($oVistoria) && $oVistoria->vistoria_lacres) {

            foreach ($oOrdemServico->ordem_servico_lacres as $oOsLacre) {
                LgDbUtil::get('OrdemServicoLacres')->delete($oOsLacre);
            }

            foreach ($oVistoria->vistoria_lacres as $oVistoriaLacre) {
                $aData = json_decode(json_encode($oVistoriaLacre), true);
                unset($aData['id']);
                $aData['ordem_servico_id'] = $oOrdemServico->id;
                $aData['descricao'] = $aData['lacre_numero'];
                $oVistoriaLacreEntity = LgDbUtil::get('VistoriaLacres')->newEntity($aData);
                LgDbUtil::get('OrdemServicoLacres')->save($oVistoriaLacreEntity);
            }

        }
    }
}
