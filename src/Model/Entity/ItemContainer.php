<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use App\Model\Entity\Lacre;
use App\Model\Entity\ContainerEntrada;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Table;

/**
 * ItemContainer Entity
 *
 * @property int $id
 * @property int $container_id
 * @property int $documento_mercadoria_item_id
 *
 * @property \App\Model\Entity\Container $container
 * @property \App\Model\Entity\DocumentosMercadoriasItem $documentos_mercadorias_item
 */
class ItemContainer extends Entity
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
        
        'container_id' => true,
        'documento_mercadoria_item_id' => true,
        'container' => true,
        'documentos_mercadorias_item' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getFilters()
    {
        return [
            [
                'name'  => 'container',
                'divClass' => 'col-lg-3',
                'label' => 'Container',
                'table' => [
                    'className' => 'ItemContainers.Containers',
                    'field'     => 'numero',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'documento_mercadoria_item',
                'divClass' => 'col-lg-3',
                'label' => 'Docuemento Mercadoria Item',
                'table' => [
                    'className' => 'ItemContainers.DocumentosMercadoriasItens',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ]
        ];
    }

    public static function saveItemContainer($that, $aMercadoria, $entidadeMercadorias, $iDocumentoTransporte_id) 
    {
        $oEntityItemContainer = TableRegistry::getTableLocator()->get('ItemContainers');
        $that->loadModel('ItemContainers');
        foreach ($aMercadoria['containers'] as $aContainer) {

            if ($aContainer['documento_mercadoria_itens_ids']) {

                $aDocMercadoriaIDs = explode(",", $aContainer['documento_mercadoria_itens_ids']);

                foreach ($aDocMercadoriaIDs as $iDocID) {

                    $iQuantidade = DocumentosMercadoriasItem::getQuantidadeFromId($iDocID);
                    $aContainer['item_container_id'] = self::getId($aContainer, $iDocID, $iDocumentoTransporte_id);
                    $aData = [
                        'id'                           => $aContainer['item_container_id'] ? $aContainer['item_container_id'] : '',
                        'container_id'                 => $aContainer['container_id'],
                        'documento_mercadoria_item_id' => $iDocID,
                        'documento_transporte_id'      => $iDocumentoTransporte_id,
                        'quantidade'                   => $iQuantidade,
                    ];
                    
                    $entidadeItemContainer = $that->setEntity('ItemContainers', $aData);
                    $entidadeItemContainer = $oEntityItemContainer->patchEntity($entidadeItemContainer, $aData);
                    $oEntityItemContainer->save($entidadeItemContainer);

                }

                Lacre::saveLacre($that, $aContainer, $iDocumentoTransporte_id);
                ContainerEntrada::saveContainerEntrada($that, $aContainer, $iDocumentoTransporte_id);

            } else {

                $aData = [
                    'id'                           => $aContainer['item_container_id'] ? $aContainer['item_container_id'] : '',
                    'container_id'                 => $aContainer['container_id'],
                    'documento_mercadoria_item_id' => $entidadeMercadorias->id,
                    'documento_transporte_id'      => $iDocumentoTransporte_id,
                    'quantidade'                   => $aContainer['quantidade'],
                ];
    
                $entidadeItemContainer = $that->setEntity('ItemContainers', $aData);
                $entidadeItemContainer = $oEntityItemContainer->patchEntity($entidadeItemContainer, $aData);
                $oEntityItemContainer->save($entidadeItemContainer);
                
                Lacre::saveLacre($that, $aContainer, $iDocumentoTransporte_id);
                ContainerEntrada::saveContainerEntrada($that, $aContainer, $iDocumentoTransporte_id);

            }
        }
    }

    public static function deleteItemContainer($iItemContainerId, $aCheckeds = null)
    {
        $oResponse = new ResponseUtil();

        $entityItemContainer = TableRegistry::getTableLocator()->get('ItemContainers');

        $oItemContainer = $entityItemContainer->find()->where(['id' => $iItemContainerId])->first();

        $iCountContainers = $entityItemContainer->find()->where([
            'container_id' => $oItemContainer->container_id,
            'documento_transporte_id' => $oItemContainer->documento_transporte_id
        ])->count();

        if ($iCountContainers > 1 && !$aCheckeds) {

            if ($aCheckeds) {
                $oItemContainers = $entityItemContainer->find()->where([
                    'documento_mercadoria_item_id IN' => $aCheckeds,
                    'container_id' => $oItemContainer->container_id,
                    'documento_transporte_id' => $oItemContainer->documento_transporte_id,
                ])->toArray();
                $aItensIDs = [];
                foreach ($oItemContainers as $oItemContainer) {
                    $aItensIDs[] = $oItemContainer->id;
                }

                $entityItemContainer->deleteAll(array('ItemContainer.id IN' => $aItensIDs), false);
            } else if ($oItemContainer) {
                $entityItemContainer->delete($oItemContainer);
            }

            return $oResponse
                ->setStatus(200)
                ->setMessage('Item Container removido com sucesso!')
                ->setTitle('Sucesso!');
            
        } else {

            $entityContainerEntradas = TableRegistry::getTableLocator()->get('ContainerEntradas');
            $aContainerEntradas = $entityContainerEntradas->find()->where([
                'documento_transporte_id' => $oItemContainer->documento_transporte_id,
                'container_id'            => $oItemContainer->container_id
            ])->toArray();

            $aContainerEntradasIDs = [];
            foreach ($aContainerEntradas as $aContainerEntrada) {
                $aContainerEntradasIDs[] = $aContainerEntrada->id;
            }

            $entityLacres = TableRegistry::getTableLocator()->get('Lacres');
            $aLacres = $entityLacres->find()->where([
                'documento_transporte_id' => $oItemContainer->documento_transporte_id,
                'container_id'            => $oItemContainer->container_id
            ]);

            $aLacresIDs = [];
            foreach ($aLacres as $aLacre) {
                $aLacresIDs[] = $aLacre->id;
            }

            if ($aContainerEntradasIDs)
                $entityContainerEntradas->deleteAll(array('ContainerEntradas.id IN' => $aContainerEntradasIDs), false);
            if ($aLacresIDs)
                $entityLacres->deleteAll(array('Lacres.id IN' => $aLacresIDs), false);

            if ($aCheckeds) {
                $oItemContainers = $entityItemContainer->find()->where([
                    'documento_mercadoria_item_id IN' => $aCheckeds,
                    'container_id' => $oItemContainer->container_id,
                    'documento_transporte_id' => $oItemContainer->documento_transporte_id,
                ])->toArray();

                $aItensIDs = [];
                foreach ($oItemContainers as $oItemContainer) {
                    $aItensIDs[] = $oItemContainer->id;
                }

                $entityItemContainer->deleteAll(array('ItemContainer.id IN' => $aItensIDs), false);
            } else {
                if ($oItemContainer)
                    $entityItemContainer->delete($oItemContainer);
            }
            
            return $oResponse
                ->setStatus(200)
                ->setMessage('Item Container removido com sucesso!')
                ->setTitle('Sucesso!');

        }

        return $oResponse
            ->setStatus(400)
            ->setMessage('Erro ao remover Item Container!')
            ->setTitle('Ops...!');

    }

    public static function getId($aContainer, $iDocID, $iDocumentoTransporte_id)
    {
        $entityItemContainer = TableRegistry::getTableLocator()->get('ItemContainers');
        $oItemContainer = $entityItemContainer->find()->where([
            // 'container_id'                 => $aContainer['container_id'],
            'documento_mercadoria_item_id' => $iDocID,
            // 'documento_transporte_id'      => $iDocumentoTransporte_id
        ])->first();

        if ($oItemContainer)
            return $oItemContainer->id;

        return null;
    }

    public static function saveSingleItemContainer($iContainerID, $oDocumentoMercadoriaItem, $dQtde)
    {
        if (!$iContainerID)
            return null;
            
        $oDocumentoMercadoria = LgDbUtil::getByID('DocumentosMercadorias', $oDocumentoMercadoriaItem->documentos_mercadoria_id);

        $aData = [
            'container_id' => $iContainerID,
            'documento_mercadoria_item_id' => $oDocumentoMercadoriaItem->id,
            'documento_transporte_id' => $oDocumentoMercadoria->documento_transporte_id
        ];

        $oItemContainer = LgDbUtil::getFirst('ItemContainers', $aData);

        if (!$oItemContainer)
            $oItemContainer = LgDbUtil::saveNew('ItemContainers', $aData + [
                'quantidade' => $dQtde
            ]);

        $oItemContainer->quantidade = $dQtde;
        
        LgDbUtil::save('ItemContainers', $oItemContainer);
    }
}
