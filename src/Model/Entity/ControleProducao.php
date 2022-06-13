<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

/**
 * ControleProducao Entity
 *
 * @property int $id
 * @property int|null $endereco_producao_id
 * @property \Cake\I18n\Time|null $data_hora_inicio
 * @property \Cake\I18n\Time|null $data_hora_fim
 * @property int|null $produto_id
 * @property float|null $quantidade
 *
 * @property \App\Model\Entity\Endereco $endereco
 * @property \App\Model\Entity\Produto $produto
 * @property \App\Model\Entity\ControleProducaoParalizacao[] $controle_producao_paralizacoes
 * @property \App\Model\Entity\PlanejamentoMovimentacaoProduto[] $planejamento_movimentacao_produtos
 */
class ControleProducao extends Entity
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
        
        'endereco_producao_id' => true,
        'data_hora_inicio' => true,
        'data_hora_fim' => true,
        'produto_id' => true,
        'quantidade' => true,
        'endereco' => true,
        'produto' => true,
        'controle_producao_paralizacoes' => true,
        'planejamento_movimentacao_produtos' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function iniciar($aData)
    {
        $oResponse = new ResponseUtil();

        $oControleProducao = LgDbUtil::getByID('ControleProducoes', $aData['aData']['iControleProducaoID']);
        if ($oControleProducao->data_hora_inicio)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('O Controle de Produção já foi iniciado!');

        $oControleProducao->data_hora_inicio = date('Y-m-d H:i:s');
        $oControleProducao = LgDbUtil::save('ControleProducoes', $oControleProducao, true);

        if ($oControleProducao->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu um erro ao iniciar o Controle de Produção!');

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('O Controle de Produção foi iniciado com sucesso!');
    }

    public static function parar($aData)
    {
        $oResponse = new ResponseUtil();

        $oControleProducaoParalizacao = self::getControleProducaoParado($aData['aData']['iControleProducaoID']);
        if ($oControleProducaoParalizacao)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('O Controle de Produção já está parado!');

        $dDataInicio = date('Y-m-d H:i:s');
        $aDataInsert = [
            'data_hora_inicio'     => $dDataInicio,
            'controle_producao_id' => $aData['aData']['iControleProducaoID']
        ];

        $oControleProducaoParalizacao = LgDbUtil::saveNew('ControleProducaoParalizacoes', $aDataInsert, true);
        
        if ($oControleProducaoParalizacao->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu um erro ao parar o Controle de Produção!');

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('O Controle de Produção foi parado com sucesso!');
    }

    public static function retomar($aData)
    {
        $oResponse = new ResponseUtil();

        $oControleProducaoParalizacao = self::getControleProducaoParado($aData['aData']['iControleProducaoID']);
        if (!$oControleProducaoParalizacao)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('O Controle de Produção não está parado!');

        $oControleProducaoParalizacao->data_hora_fim = date('Y-m-d H:i:s');
        $oControleProducaoParalizacao = LgDbUtil::save('ControleProducaoParalizacoes', $oControleProducaoParalizacao, true);
    
        if ($oControleProducaoParalizacao->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu um erro ao retomar o Controle de Produção!');

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('O Controle de Produção foi retomado com sucesso!');
    }

    public static function getControleProducaoParado($iControleProducaoID)
    {
        return LgDbUtil::getFind('ControleProducaoParalizacoes')
            ->where([
                'ControleProducaoParalizacoes.controle_producao_id' => $iControleProducaoID,
                'ControleProducaoParalizacoes.data_hora_fim IS'     => null
            ])
            ->order([
                'ControleProducaoParalizacoes.id' => 'DESC'
            ])
            ->first();
    }

    public static function efetivar($aData)
    {
        $oResponse = new ResponseUtil();

        $oControleProducao = LgDbUtil::getByID('ControleProducoes', $aData['aData']['iControleProducaoID']);
        if ($oControleProducao->data_hora_fim)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('O Controle de Produção já foi efetivado!');

        $oControleProducao->data_hora_fim = date('Y-m-d H:i:s');
        $oControleProducao = LgDbUtil::save('ControleProducoes', $oControleProducao, true);

        if ($oControleProducao->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu um erro ao efetivar o Controle de Produção!');

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('O Controle de Produção foi efetivado com sucesso!');
    }

    public static function getPercentualTransferido($oControleProducao)
    {
        foreach ($oControleProducao->produto->produto_estruturas as $iKey => $oProdutoEstrutura) {

            $oEstoqueEnderecos = LgDbUtil::getFind('EstoqueEnderecos')
                ->where([
                    'produto_id'  => $oProdutoEstrutura->produtos_componente->id,
                    'endereco_id' => $oControleProducao->endereco_producao_id
                ])
                ->toArray();

            if ($oEstoqueEnderecos) {

                $iQuantidadeEstoque = 0;
                foreach ($oEstoqueEnderecos as $oEstoqueEndereco)
                    $iQuantidadeEstoque += $oEstoqueEndereco->qtde_saldo;

                $iPorcentagem = ($iQuantidadeEstoque * 100) / $oControleProducao->quantidade;
                $oControleProducao->produto->produto_estruturas[$iKey]['porcentagem_transferia'] = (float)$iPorcentagem;

            } else {

                $oControleProducao->produto->produto_estruturas[$iKey]['porcentagem_transferia'] = 0;

            }
            
        }

        return $oControleProducao;
    }

    public static function check($iControleProducaoID)
    {
        $oResponse = new ResponseUtil();

        $oControleProducao = LgDbUtil::getByID('ControleProducoes', $iControleProducaoID);

        if (!$oControleProducao->data_hora_inicio)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('O Controle de Produção ainda não foi iniciado!');

        if ($oControleProducao->data_hora_fim)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('O Controle de Produção já foi efetivado!');

        $oControleProducaoParalizacao = self::getControleProducaoParado($iControleProducaoID);
        if ($oControleProducaoParalizacao)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('O Controle de Produção está parado!');

        return $oResponse
            ->setStatus(200);
    }

}
