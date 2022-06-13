<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

/**
 * PlanejamentoMovimentacaoVeiculo Entity
 *
 * @property int $id
 * @property int|null $veiculo_id
 * @property int|null $planejamento_movimentacao_produto_id
 *
 * @property \App\Model\Entity\Veiculo $veiculo
 * @property \App\Model\Entity\PlanejamentoMovimentacaoProduto $planejamento_movimentacao_produto
 */
class PlanejamentoMovimentacaoVeiculo extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getByVeiculo($iVeiculoID)
    {
        $oResponse = new ResponseUtil();

        $oPlanejamentoVeiculo = LgDbUtil::getFind('PlanejamentoMovimentacaoVeiculos')
            ->where(['PlanejamentoMovimentacaoVeiculos.veiculo_id' => $iVeiculoID])
            ->contain('PlanejamentoMovimentacaoProdutos')
            ->innerJoinWith('PlanejamentoMovimentacaoProdutos', function ($q) {
                return $q->where([
                    'PlanejamentoMovimentacaoProdutos.data_hora_inicio IS NOT' => null,
                    'PlanejamentoMovimentacaoProdutos.data_hora_fim IS' => null
                ]);
            })
            ->order(['PlanejamentoMovimentacaoVeiculos.id' => 'DESC'])
            ->first();

        if (!$oPlanejamentoVeiculo)
            return $oResponse
                ->setStatus(400)
                ->setMessage('Não existe Planejamento de Movimentação de Veiculos em aberto para esse veiculo!');

        return $oResponse
            ->setStatus(200)
            ->setDataExtra($oPlanejamentoVeiculo);
    }
}
