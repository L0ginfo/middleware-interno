<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * ContainerEntrada Entity
 *
 * @property int $id
 * @property int $documento_transporte_id
 * @property int $container_id
 * @property string|null $free_time_demurrage
 *
 * @property \App\Model\Entity\DocumentosTransporte $documentos_transporte
 * @property \App\Model\Entity\Container $container
 */
class ContainerEntrada extends Entity
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
        
        'documento_transporte_id' => true,
        'container_id' => true,
        'free_time_demurrage' => true,
        'documentos_transporte' => true,
        'container' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getFilters()
    {
        return [
            [
                'name'  => 'documento_transporte',
                'divClass' => 'col-lg-3',
                'label' => 'Documento Trasnporte',
                'table' => [
                    'className' => 'ContainerEntradas.DocumentosTransportes',
                    'field'     => 'numero',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'container',
                'divClass' => 'col-lg-3',
                'label' => 'Container',
                'table' => [
                    'className' => 'ContainerEntradas.Containers',
                    'field'     => 'numero',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'free_time',
                'divClass' => 'col-lg-3',
                'label' => 'Free Time Demurrage',
                'table' => [
                    'className' => 'ContainerEntradas',
                    'field'     => 'free_time_demurrage',
                    'operacao'  => 'contem'
                ]
            ]
        ];
    }

    public static function saveContainerEntrada($that, $aContainer, $iDocumentoTransporte_id)
    {
        $aData = [
            'id'                      => $aContainer['container_entrada_id'] ? $aContainer['container_entrada_id'] : '',
            'documento_transporte_id' => $iDocumentoTransporte_id,
            'container_id'            => $aContainer['container_id'],
            'free_time_demurrage'     => $aContainer['free_time']
        ];
        
        $oContainerEntrada = LgDbUtil::getFirst('ContainerEntradas', [
            'documento_transporte_id' => $iDocumentoTransporte_id,
            'container_id'            => $aContainer['container_id'],
        ]);
        $oContainerEntradaEntity = LgDbUtil::get('ContainerEntradas');

        if (!$oContainerEntrada) {
            $oContainerEntrada = LgDbUtil::saveNew('ContainerEntradas', $aData);
        } else {
            $oContainerEntrada = $oContainerEntradaEntity->patchEntity($oContainerEntrada, $aData);
            LgDbUtil::save('ContainerEntradas', $oContainerEntrada);
        }

        /*$oEntityContainerEntrada = TableRegistry::getTableLocator()->get('ContainerEntradas');

        $that->loadModel('ContainerEntradas');
        $entidadeContainerEntradas = $that->setEntity('ContainerEntradas', $aData);

        $entidadeContainerEntradas = $oEntityContainerEntrada->patchEntity($entidadeContainerEntradas, $aData);
        $oEntityContainerEntrada->save($entidadeContainerEntradas);*/
    }

    public static function saveSingleContainerEntrada($iContainerID, $oDocumentoMercadoriaItem)
    {
        if (!$iContainerID)
            return null;
            
        $iFreeTimeDemurrage = 50;
        $oDocumentoMercadoria = LgDbUtil::getByID('DocumentosMercadorias', $oDocumentoMercadoriaItem->documentos_mercadoria_id);

        $aData = [
            'container_id' => $iContainerID,
            'documento_transporte_id' => $oDocumentoMercadoria->documento_transporte_id
        ];

        $oContainerEntrada = LgDbUtil::getFirst('ContainerEntradas', $aData);

        if (!$oContainerEntrada)
            $oContainerEntrada = LgDbUtil::saveNew('ContainerEntradas', $aData + [
                'free_time_demurrage' => $iFreeTimeDemurrage
            ]);

        $oContainerEntrada->free_time_demurrage = $iFreeTimeDemurrage;
        
        LgDbUtil::save('ContainerEntradas', $oContainerEntrada);
    }

    public static function saveContainerEntradasEstufados($iDocumentoMercadoriaItemID, $iContainerID, $iValue)
    {
        $oResponse = new ResponseUtil();

        $oEntradaSaidaContainer   = EntradaSaidaContainer::getLastByContainerId($iContainerID);
        $oDocumentoMercadoriaItem = LgDbUtil::getFind('DocumentosMercadoriasItens')
            ->select(['DocumentosMercadorias.documento_transporte_id'])
            ->contain(['DocumentosMercadorias'])
            ->where(['DocumentosMercadoriasItens.id' => $iDocumentoMercadoriaItemID])
            ->first();

        $aData = [
            'documento_transporte_id'    => $oDocumentoMercadoriaItem->documentos_mercadoria->documento_transporte_id,
            'container_id'               => $oEntradaSaidaContainer->container_id,
            'entrada_saida_container_id' => $oEntradaSaidaContainer->id,
            'estufado'                   => 1
        ];

        LgDbUtil::getOrSaveNew('ContainerEntradas', $aData);

        $aData = [
            'documento_transporte_id'      => $oDocumentoMercadoriaItem->documentos_mercadoria->documento_transporte_id,
            'container_id'                 => $oEntradaSaidaContainer->container_id,
            'entrada_saida_container_id'   => $oEntradaSaidaContainer->id,
            'documento_mercadoria_item_id' => $iDocumentoMercadoriaItemID,
            'estufado'                     => 1,
        ];

        $oItemContainer = LgDbUtil::getOrSaveNew('ItemContainers', $aData);
        if ($oItemContainer->quantidade)
            $oItemContainer->quantidade += $iValue;
        else 
            $oItemContainer->quantidade = $iValue;

        LgDbUtil::save('ItemContainers', $oItemContainer);

        return $oResponse->setStatus(200);
    }

    public static function deleteContainerEntradasEstufados($oOSItemLote)
    {
        $oDocumentoMercadoriaItem = LgDbUtil::getFind('DocumentosMercadoriasItens')
            ->select(['DocumentosMercadorias.documento_transporte_id'])
            ->contain(['DocumentosMercadorias'])
            ->where(['DocumentosMercadoriasItens.id' => $oOSItemLote->documento_mercadoria_item_id])
            ->first();

        $oContainerEntradas = LgDbUtil::getFind('ContainerEntradas')
            ->where([
                'documento_transporte_id'    => $oDocumentoMercadoriaItem->documentos_mercadoria->documento_transporte_id,
                'container_id'               => $oOSItemLote->container_id,
                'entrada_saida_container_id' => $oOSItemLote->entrada_saida_container_id,
                'estufado'                   => 1,
            ])
            ->first();
        
        if (!$oContainerEntradas)
            return true;
        
        $oContainerEntradaEntity = LgDbUtil::get('ContainerEntradas');
        $oContainerEntradaEntity->delete($oContainerEntradas);

        return true;
    }

    public static function deleteItemContainersEstufados($oOSItemLote)
    {
        $oDocumentoMercadoriaItem = LgDbUtil::getFind('DocumentosMercadoriasItens')
            ->select(['DocumentosMercadorias.documento_transporte_id'])
            ->contain(['DocumentosMercadorias'])
            ->where(['DocumentosMercadoriasItens.id' => $oOSItemLote->documento_mercadoria_item_id])
            ->first();

        $oItemContainers = LgDbUtil::getFind('ItemContainers')
        ->where([
            'documento_transporte_id'      => $oDocumentoMercadoriaItem->documentos_mercadoria->documento_transporte_id,
            'container_id'                 => $oOSItemLote->container_id,
            'entrada_saida_container_id'   => $oOSItemLote->entrada_saida_container_id,
            'documento_mercadoria_item_id' => $oOSItemLote->documento_mercadoria_item_id,
            'estufado'                     => 1,
        ])
        ->first();
    
        if (!$oItemContainers)
            return true;
        
        $oItemContainersEntity = LgDbUtil::get('ItemContainers');
        $oItemContainersEntity->delete($oItemContainers);

        return true;
    }

    public static function deleteItemContainersEstufadosDesova($oOSItemLote, $value)
    {
        $oDocumentoMercadoriaItem = LgDbUtil::getFind('DocumentosMercadoriasItens')
            ->select(['DocumentosMercadorias.documento_transporte_id'])
            ->contain(['DocumentosMercadorias'])
            ->where(['DocumentosMercadoriasItens.id' => $oOSItemLote->documento_mercadoria_item_id])
            ->first();

        $oItemContainers = LgDbUtil::getFind('ItemContainers')
        ->where([
            'documento_transporte_id'      => $oDocumentoMercadoriaItem->documentos_mercadoria->documento_transporte_id,
            'container_id'                 => $oOSItemLote->container_id,
            'entrada_saida_container_id'   => $oOSItemLote->entrada_saida_container_id,
            'documento_mercadoria_item_id' => $oOSItemLote->documento_mercadoria_item_id,
            'estufado'                     => 1,
        ])
        ->first();
    
        if (!$oItemContainers)
            return true;
        
        if ($oItemContainers->quantidade == $value) {
            $oItemContainersEntity = LgDbUtil::get('ItemContainers');
            $oItemContainersEntity->delete($oItemContainers);
        } else {
            $oItemContainers->quantidade -= $value;
            LgDbUtil::save('ItemContainers', $oItemContainers);
        }

        return true;
    }
}
