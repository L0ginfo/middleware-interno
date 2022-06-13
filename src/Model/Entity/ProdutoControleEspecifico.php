<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

/**
 * ProdutoControleEspecifico Entity
 *
 * @property int $id
 * @property int $controle_especifico_id
 * @property int $produto_id
 *
 * @property \App\Model\Entity\ControleEspecifico $controle_especifico
 * @property \App\Model\Entity\Produto $produto
 */
class ProdutoControleEspecifico extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function save($aControleEspecificosIDs, $iProdutoID)
    {
        $oResponse = new ResponseUtil();

        foreach ($aControleEspecificosIDs as $key => $value) {
            
            $aInsert = [
                'controle_especifico_id' => $value,
                'produto_id'             => $iProdutoID
            ];

            if (!LgDbUtil::saveNew('ProdutoControleEspecificos', $aInsert, true))
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Ocorreu algum erro ao tentar adicionar os Controles Específicos!');

        }

        return $oResponse
            ->setStatus(200);
    }

    public static function saveOrDelete($aData)
    {
        $oResponse = new ResponseUtil();

        $oProdutoControleEspecifico = LgDbUtil::getFind('ProdutoControleEspecificos')
            ->where([
                'controle_especifico_id' => $aData['controle_especifico_id'],
                'produto_id'             => $aData['produto_id']
            ])
            ->first();


        if ($aData['selected'] == 'true' && !$oProdutoControleEspecifico) {

            $aInsert = [
                'controle_especifico_id' => $aData['controle_especifico_id'],
                'produto_id'             => $aData['produto_id']
            ];

            if (!LgDbUtil::saveNew('ProdutoControleEspecificos', $aInsert, true))
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Ocorreu algum erro ao tentar editar os Controles Específicos!');

        } else if ($aData['selected'] == 'false' && $oProdutoControleEspecifico) {

            $oEntityProdutoControleEspecifico = LgDbUtil::get('ProdutoControleEspecificos');

            if (!$oEntityProdutoControleEspecifico->delete($oProdutoControleEspecifico))
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Ocorreu algum erro ao tentar excluir os Controles Específicos!');

        }

        return $oResponse->setStatus(200);
    }

    public static function saveInDocMercadoria($aData)
    {
        $oResponse = new ResponseUtil();

        $oProduto = LgDbUtil::getByID('Produtos', $aData['produto_id']);

        if (!$oProduto)
            return $oResponse
                ->setStatus(204);

        if ($oProduto->tem_controle_especifico == 0)
            return $oResponse
                ->setStatus(204);

        $oProdutoControleEspecificos = LgDbUtil::getFind('ProdutoControleEspecificos')
            ->where(['produto_id' => $aData['produto_id']])
            ->toArray();

        if (!$oProdutoControleEspecificos)
            return $oResponse
                ->setStatus(200);

        foreach ($oProdutoControleEspecificos as $oProdutoControleEspecifico) {
            
            $aDataInsert = [
                'controle_especifico_id'       => $oProdutoControleEspecifico->controle_especifico_id,
                'documento_mercadoria_item_id' => $aData['mercadoria_id']
            ];

            LgDbUtil::getOrSaveNew('DocumentoMercadoriaItemControleEspecificos', $aDataInsert);

        }

        $oDocItemControleEspecificos = LgDbUtil::getFind('DocumentoMercadoriaItemControleEspecificos')
            ->contain('ControleEspecificos')
            ->where(['DocumentoMercadoriaItemControleEspecificos.documento_mercadoria_item_id' => $aData['mercadoria_id']])
            ->toArray();

        $aArrayOptions = [];
        foreach ($oDocItemControleEspecificos as $oDocItemControleEspecifico)
            $aArrayOptions[$oDocItemControleEspecifico->controle_especifico_id] = [
                'descricao' => $oDocItemControleEspecifico->controle_especifico->descricao,
                'selected'  => $oDocItemControleEspecifico->selecionado == 1 ? true : false
            ];

        return $oResponse
            ->setStatus(200)
            ->setDataExtra($aArrayOptions);
    }

    public static function saveOrDeleteInDocMercadoriaItem($aData)
    {
        $oResponse = new ResponseUtil();

        $oDocMercItemControleEspecifico = LgDbUtil::getFind('DocumentoMercadoriaItemControleEspecificos')
            ->where([
                'controle_especifico_id'       => $aData['controle_especifico_id'],
                'documento_mercadoria_item_id' => $aData['item_id']
            ])
            ->first();


        if ($aData['selected'] == 'true' && $oDocMercItemControleEspecifico) {

            $oDocMercItemControleEspecifico->selecionado = 1;

            if (!LgDbUtil::save('DocumentoMercadoriaItemControleEspecificos', $oDocMercItemControleEspecifico, true))
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Ocorreu algum erro ao tentar editar os Controles Específicos desse Documento!');

            // $aInsert = [
            //     'controle_especifico_id'       => $aData['controle_especifico_id'],
            //     'documento_mercadoria_item_id' => $aData['item_id']
            // ];

            // if (!LgDbUtil::saveNew('DocumentoMercadoriaItemControleEspecificos', $aInsert, true))
            //     return $oResponse
            //         ->setStatus(400)
            //         ->setTitle('Ops!')
            //         ->setMessage('Ocorreu algum erro ao tentar editar os Controles Específicos desse Documento!');

        } else if ($aData['selected'] == 'false' && $oDocMercItemControleEspecifico) {

            $oDocMercItemControleEspecifico->selecionado = 0;

            if (!LgDbUtil::save('DocumentoMercadoriaItemControleEspecificos', $oDocMercItemControleEspecifico, true))
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Ocorreu algum erro ao tentar editar os Controles Específicos desse Documento!');

            // $oEntityDocumentoMercadoriaItemControleEspecificos = LgDbUtil::get('DocumentoMercadoriaItemControleEspecificos');

            // if (!$oEntityDocumentoMercadoriaItemControleEspecificos->delete($oDocMercItemControleEspecifico))
            //     return $oResponse
            //         ->setStatus(400)
            //         ->setTitle('Ops!')
            //         ->setMessage('Ocorreu algum erro ao tentar excluir os Controles Específicos desse Documento!');

        }

        return $oResponse->setStatus(200);
    }

    public static function getDocMercItensControleEspecificos($aData)
    {
        $oResponse = new ResponseUtil();

        $oProduto = LgDbUtil::getByID('Produtos', $aData['produto_id']);
        if ($oProduto->tem_controle_especifico == 0)
            return $oResponse->setStatus(204);

        $oDocumentoMercadoriaItem = LgDbUtil::getFind('DocumentosMercadoriasItens')
            ->where([
                'documentos_mercadoria_id' => $aData['doc_merc_id'],
                'produto_id'               => $oProduto->id,
                'unidade_medida_id'        => $oProduto->unidade_medida_id
            ])
            ->first();

        if (!$oDocumentoMercadoriaItem)
            return $oResponse->setStatus(204);

        $oDocMercItemControleEspecificos = LgDbUtil::getFind('DocumentoMercadoriaItemControleEspecificos')
            ->contain(['ControleEspecificos'])
            ->where([
                'documento_mercadoria_item_id' => $oDocumentoMercadoriaItem->id,
                'selecionado'                  => 1
            ])
            ->toArray();
        
        if (!$oDocMercItemControleEspecificos)
            return $oResponse->setStatus(204);

        $aControleEspecificosOptions = [];
        foreach ($oDocMercItemControleEspecificos as $oDocMercItemControleEspecifico)
            $aControleEspecificosOptions[$oDocMercItemControleEspecifico->controle_especifico->id] = $oDocMercItemControleEspecifico->controle_especifico->descricao;

        return $oResponse
            ->setStatus(200)
            ->setDataExtra($aControleEspecificosOptions);
    }
}
