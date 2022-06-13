<?php
namespace App\Model\Entity;

use App\RegraNegocio\OrdemServico\OrdermServicoSku;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

class ControleProducaoProdutoComposicao extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function saveByControleProducao($oControleProducao)
    {
        $oResponse = new ResponseUtil();

        $oProdutoEstruturas = LgDbUtil::getFind('ProdutoEstruturas')
            ->where(['ProdutoEstruturas.produto_id' => $oControleProducao->produto_id])
            ->toArray();

        if (!$oProdutoEstruturas)
            return $oResponse
                ->setStatus(400)
                ->setMessage('O produto final não tem estruturas!');

        foreach ($oProdutoEstruturas as $oProdutoEstrutura) {

            $aDataInsert = [
                'controle_producao_id'  => $oControleProducao->id,
                'produto_composicao_id' => $oProdutoEstrutura->produto_componente_id,
                'percentual'            => $oProdutoEstrutura->percentual
            ];

            $oControleProducaoProdutoComposicao = LgDbUtil::getOrSaveNew('ControleProducaoProdutoComposicoes', $aDataInsert, true);

            if ($oControleProducaoProdutoComposicao->hasErrors())
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Ocorreu um erro ao gravar o Controle Produção Produto Composições!');

        }

        return $oResponse
            ->setStatus(200);
    }

    public static function getPercentual($iControleProducaoID, $iProdutoComponenteID)
    {
        $oControleProducaoProdutoComposicao = LgDbUtil::getFind('ControleProducaoProdutoComposicoes')
            ->where([
                'controle_producao_id'  => $iControleProducaoID,
                'produto_composicao_id' => $iProdutoComponenteID
            ])
            ->first();

        if (!$oControleProducaoProdutoComposicao)
            return null;

        return $oControleProducaoProdutoComposicao->percentual;
    }

    public static function setPercentual($aData)
    {
        $oResponse = new ResponseUtil();

        $oControleProducaoProdutoComposicao = LgDbUtil::getFind('ControleProducaoProdutoComposicoes')
            ->where([
                'controle_producao_id'  => $aData['aData']['iControleProducaoID'],
                'produto_composicao_id' => $aData['aData']['iProdutoComponenteID']
            ])
            ->first();

        if (!$oControleProducaoProdutoComposicao)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Não foi possível encontrar o Controle Produção Produto Componente!');

        $oControleProducaoProdutoComposicao->percentual = $aData['aData']['iPercentual'];
        $oControleProducaoProdutoComposicao = LgDbUtil::save('ControleProducaoProdutoComposicoes', $oControleProducaoProdutoComposicao, true);

        if ($oControleProducaoProdutoComposicao->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu um erro ao salvar o Controle Produção Produto Componente!');

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('O Controle Produção Produto Componente! foi salvo com sucesso!');
    }

}
