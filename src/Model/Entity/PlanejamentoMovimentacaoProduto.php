<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;


class PlanejamentoMovimentacaoProduto extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getByResv($oProgramacao, $iProdutoID)
    {
        $oResponse = new ResponseUtil();

        if ($iProdutoID)
            $oPlanejamentoMovimentacaoProduto = LgDbUtil::getFind('PlanejamentoMovimentacaoProdutos')
                ->where([
                    'PlanejamentoMovimentacaoProdutos.data_hora_inicio IS NOT' => null,
                    'PlanejamentoMovimentacaoProdutos.data_hora_fim IS'        => null,
                    'PlanejamentoMovimentacaoProdutos.produto_id'              => $iProdutoID,
                    'PlanejamentoMovimentacaoProdutos.operacao_id'             => $oProgramacao->operacao_id,
                ])
                ->first();
        else
            $oPlanejamentoMovimentacaoProduto = LgDbUtil::getFind('PlanejamentoMovimentacaoProdutos')
                ->where([
                    'PlanejamentoMovimentacaoProdutos.data_hora_inicio IS NOT' => null,
                    'PlanejamentoMovimentacaoProdutos.data_hora_fim IS'        => null,
                    'PlanejamentoMovimentacaoProdutos.operacao_id'             => $oProgramacao->operacao_id,
                ])
                ->first();       
        

        return $oResponse
            ->setDataExtra($oPlanejamentoMovimentacaoProduto ?: null);
    }

    public static function getByEnderecoOrigem($oResv, $iEnderecoID)
    {
        $oResponse = new ResponseUtil();

        $oPlanejamentoMovimentacaoProduto = LgDbUtil::getFind('PlanejamentoMovimentacaoProdutos')
            ->where([
                'PlanejamentoMovimentacaoProdutos.data_hora_inicio IS NOT' => null,
                'PlanejamentoMovimentacaoProdutos.data_hora_fim IS'        => null,
                'PlanejamentoMovimentacaoProdutos.operacao_id'             => $oResv->operacao_id,
                'PlanejamentoMovimentacaoProdutos.endereco_origem_id'      => $iEnderecoID,
            ])
            ->first();

        if (!$oPlanejamentoMovimentacaoProduto)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Não foi encontrado nenhum Plano de Movimentação de Produto para essa Leira!');

        if ($oPlanejamentoMovimentacaoProduto->controle_producao_id) {

            $oResponse = ControleProducao::check($oPlanejamentoMovimentacaoProduto->controle_producao_id);
            if ($oResponse->getStatus() != 200)
                return $oResponse;

        } 

        return $oResponse
            ->setStatus(200)
            ->setDataExtra($oPlanejamentoMovimentacaoProduto ?: null);
    }

}
