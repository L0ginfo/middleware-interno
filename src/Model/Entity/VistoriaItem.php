<?php

namespace App\Model\Entity;

use App\Util\DateUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

class VistoriaItem extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function saveVistoriaItemContainer($aData)
    {
        $oResponse = new ResponseUtil();

        $oResponse = EntradaSaidaContainer::updateContainerFormaUso($aData['container_id'], $aData['container_forma_uso_id']);
        if ($oResponse->getStatus() != 200)
            return $oResponse
                ->setTitle('Ops!')
                ->setMessage('Ocorreu algum erro ao atualizar a forma de uso do container.');

        $oVistoriaItem = LgDbUtil::getFirst('VistoriaItens', [
            'vistoria_id'  => $aData['vistoria_id'],
            'container_id' => $aData['container_id']
        ]);

        if (!$oVistoriaItem) {

            $aDataInsert = [
                'vistoria_id'            => $aData['vistoria_id'],
                'container_id'           => $aData['container_id'],
                'tara'                   => $aData['tara'],
                'mgw'                    => $aData['mgw'],
                'tipo_iso'               => $aData['tipo_iso'],
                'ano_fabricacao'         => $aData['ano_fabricacao'],
                'data_hora_vistoria'     => DateUtil::dateTimeToDB(date('Y-m-d H:i:s')),
                'usuario_id'             => $_SESSION['Auth']['User']['id'],
                'container_forma_uso_id' => $aData['container_forma_uso_id']
            ];

            $oVistoriaItem = LgDbUtil::saveNew('VistoriaItens', $aDataInsert);
            if (!$oVistoriaItem) 
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Ocorreu algum erro ao vistoriar o container');
            
            return $oResponse
                ->setStatus(200)
                ->setTitle('Sucesso!')
                ->setMessage('Container vistoriado com sucesso');

        } 
    }

    public static function addVistoriaItensCargaGeral($oVistoria, $oOrdemServico)
    {
        $oResponse = new ResponseUtil();

        foreach ($oOrdemServico->ordem_servico_itens as $oOrdemServicoItem) {

            if (!$oOrdemServicoItem->container_id) {

                $aDataInsert = [
                    'vistoria_id'                  => $oVistoria->id,
                    'usuario_id'                   => $_SESSION['Auth']['User']['id'],
                    'lote_codigo'                  => $oOrdemServicoItem->lote_codigo,
                    'lote_item'                    => $oOrdemServicoItem->lote_item,
                    'sequencia_item'               => $oOrdemServicoItem->sequencia_item,
                    'quantidade'                   => $oOrdemServicoItem->quantidade,
                    'peso'                         => $oOrdemServicoItem->peso,
                    'temperatura'                  => $oOrdemServicoItem->temperatura,
                    'm2'                           => $oOrdemServicoItem->m2,
                    'm3'                           => $oOrdemServicoItem->m3,
                    'ordem_servico_id'             => $oOrdemServicoItem->ordem_servico_id,
                    'unidade_medida_id'            => $oOrdemServicoItem->unidade_medida_id,
                    'documento_mercadoria_item_id' => $oOrdemServicoItem->documento_mercadoria_item_id,
                    'embalagem_id'                 => $oOrdemServicoItem->embalagem_id,
                    'produto_id'                   => $oOrdemServicoItem->produto_id,
                    'lote'                         => $oOrdemServicoItem->lote,
                    'serie'                        => $oOrdemServicoItem->serie,
                    'validade'                     => $oOrdemServicoItem->validade,
                    'endereco_id'                  => $oOrdemServicoItem->endereco_id,
                    'status_estoque_id'            => $oOrdemServicoItem->status_estoque_id
                ];

                $oVistoriaItem = LgDbUtil::saveNew('VistoriaItens', $aDataInsert);
                if (!$oVistoriaItem) 
                    return $oResponse
                        ->setStatus(400)
                        ->setTitle('Ops!')
                        ->setMessage('Ocorreu algum erro ao salvar os itens da Vistoria');
            
            }

        }

        return $oResponse
            ->setStatus(200);
    }

    public static function getDataContainerContainerFormaUso($aData)
    {
        if (@!$aData['resv_id'] || @!$aData['container_id'])
            return null;

        $oVistoriaItem = self::getVistoriaItem($aData);
        
        if (!$oVistoriaItem)
            return null;
        
        return $oVistoriaItem->container_forma_uso_id;
    }

    public static function getDataContainerContainerSituacao($aData)
    {
        if (@!$aData['resv_id'] || @!$aData['container_id'])
            return null;

        $oVistoriaItem = self::getVistoriaItem($aData);

        if (!$oVistoriaItem)
            return null;
        
        return $oVistoriaItem->situacao_container_id;
    }

    public static function getVistoriaItem($aData)
    {
        return LgDbUtil::getFind('VistoriaItens')
            ->contain(['Vistorias' => 'Programacoes'])
            ->where([
                '(Vistorias.resv_id = ' . $aData['resv_id'] . ' OR Programacoes.resv_id = ' . $aData['resv_id'] .')',
                'VistoriaItens.container_id' => $aData['container_id']
            ])
            ->first();
    }

    public static function getVistoriaItensByContainer($iDocTransporte, $iContainerId, $bSearchEstoque, $iOsId = null)
    {
        $aItemContainers = LgDbUtil::getFind('ItemContainers')
            ->contain(['DocumentosMercadoriasItens' => ['DocumentosMercadorias']])
            ->where([
                'ItemContainers.documento_transporte_id' => $iDocTransporte,
                'container_id' => $iContainerId
            ])
            ->toArray();

        $aDocMercItens = array_reduce($aItemContainers, function($carry, $oItemContainer) {
            $carry[] = $oItemContainer->documentos_mercadorias_item;
            
            return $carry;
        }, []);

        if ($bSearchEstoque)
            return self::getVistoriaItensByEstoque($aDocMercItens, $iOsId);

        return self::getVistoriaItens($aDocMercItens);
    }

    public static function getVistoriaItensByDoc($iDocTransporte, $bSearchEstoque)
    {
        $aDocumento = LgDbUtil::getFind('DocumentosTransportes')
            ->contain([
                'DocumentosMercadoriasMany' => [
                    'DocumentosMercadoriasItens' => [
                        'DocumentosMercadorias'
                    ]
                ]
            ])
            ->where(['DocumentosTransportes.id' => $iDocTransporte])
            ->first();

        $aDocMercItens = [];
        foreach ($aDocumento->documentos_mercadorias as $oDocMercadoria) {
            
            if (!$oDocMercadoria->documentos_mercadorias_itens)
                continue;

            foreach ($oDocMercadoria->documentos_mercadorias_itens as $key => $oDocMercItem) {
                $aDocMercItens[] = $oDocMercItem;
            }
        }

        if ($bSearchEstoque)
            return self::getVistoriaItensByEstoque($aDocMercItens);

        return self::getVistoriaItens($aDocMercItens);
    }

    private static function getVistoriaItensByEstoque($aDocMercItens, $iOsId = null)
    {
        $aVistoriaItens = [];
        $aLotes = array_reduce($aDocMercItens, function($carry, $oDocMercItem) {
            $carry[] = $oDocMercItem->documentos_mercadoria->lote_codigo;

            return $carry;
        }, []);

        if ($iOsId) {
            $aEstoqueEnderecos = LgDbUtil::getFind('OrdemServicoItens')
                ->where([
                    'ordem_servico_id' => $iOsId,
                    'produto_id IS NOT NULL',
                    'lote_codigo IS NOT NULL'
                ])
                ->toArray();
        } else {
            $aEstoqueEnderecos = LgDbUtil::getFind('EstoqueEnderecos')
                ->where([
                    'lote_codigo IN' => $aLotes
                ])
                ->toArray();
        }

        foreach ($aEstoqueEnderecos as $oEstoqueEndereco) {
            $oDocMercItem = array_reduce($aDocMercItens, function($carry, $oDocMercItem) use ($oEstoqueEndereco) {
                if ($oDocMercItem->produto_id == $oEstoqueEndereco->produto_id
                    && $oDocMercItem->unidade_medida_id == $oEstoqueEndereco->unidade_medida_id) {
                        $carry = $oDocMercItem;
                    }
    
                return $carry;
            }, null);

            $aEstoqueEndereco = json_decode(json_encode($oEstoqueEndereco), true);
            if ($oDocMercItem) {
                $aEstoqueEndereco['documento_mercadoria_item_id'] = $oDocMercItem->id;
                $aEstoqueEndereco['sequencia_item'] = $oDocMercItem->sequencia_item;
                $aVistoriaItens[] = $aEstoqueEndereco;
            }

        }

        return $aVistoriaItens;
    }

    private static function getVistoriaItens($aDocMercItens)
    {
        $aVistoriaItens = [];

        foreach ($aDocMercItens as $oDocMercItem) {


            $aDocMercItem = json_decode(json_encode($oDocMercItem), true);
            $aDocMercItem['documento_mercadoria_item_id'] = $oDocMercItem['id'];
            $aVistoriaItens[] = $aDocMercItem;
        }

        return $aVistoriaItens;
    }

}
