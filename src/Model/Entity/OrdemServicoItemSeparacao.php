<?php
namespace App\Model\Entity;

use App\Util\ArrayUtil;
use App\Util\EntityUtil;
use App\Util\ObjectUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * OrdemServicoItemSeparacao Entity
 *
 * @property int $id
 * @property string|null $lote_codigo
 * @property string|null $lote_item
 * @property float $qtde_saldo
 * @property float $peso_saldo
 * @property float $m2_saldo
 * @property float $m3_saldo
 * @property string|null $lote
 * @property string|null $serie
 * @property \Cake\I18n\Time|null $validade
 * @property int $unidade_medida_id
 * @property int $endereco_id
 * @property int|null $endereco_separacao_id
 * @property int $estoque_id
 * @property int $empresa_id
 * @property int|null $produto_id
 * @property int|null $ordem_servico_id
 * @property int|null $separacao_carga_item_id
 * @property string $endereco_composicao
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\UnidadeMedida $unidade_medida
 * @property \App\Model\Entity\Endereco $endereco
 * @property \App\Model\Entity\Endereco $endereco_separacao
 * @property \App\Model\Entity\Estoque $estoque
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\Produto $produto
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 */
class OrdemServicoItemSeparacao extends Entity
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
        
        'lote_codigo' => true,
        'lote_item' => true,
        'qtde_saldo' => true,
        'peso_saldo' => true,
        'm2_saldo' => true,
        'm3_saldo' => true,
        'lote' => true,
        'serie' => true,
        'validade' => true,
        'unidade_medida_id' => true,
        'endereco_id' => true,
        'endereco_separacao_id' => true,
        'estoque_id' => true,
        'empresa_id' => true,
        'produto_id' => true,
        'ordem_servico_id' => true,
        'separacao_carga_item_id' => true,
        'endereco_composicao' => true,
        'created_at' => true,
        'updated_at' => true,
        'unidade_medida' => true,
        'endereco' => true,
        'endereco_separacao' => true,
        'estoque' => true,
        'empresa' => true,
        'produto' => true,
        'ordem_servico' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
    
    public static function separaProduto($oEstoqueEnderecoReserva, $aDataSeparacao, $iOSID, $sChaveEnderecoSeparacao, $aDataExtra)
    {
        $oResponse = new ResponseUtil();
        $aOrdemServicoItemSeparacao = ObjectUtil::getAsArray($oEstoqueEnderecoReserva, true);
        unset($aOrdemServicoItemSeparacao['id']);

        $aOrdemServicoItemSeparacao['separacao_carga_item_id'] = $aDataExtra['separacao_carga_item']['id'];
        $aOrdemServicoItemSeparacao['qtde_saldo']              = $aDataSeparacao['qtde'];
        $aOrdemServicoItemSeparacao['ordem_servico_id']        = $iOSID;
        $aOrdemServicoItemSeparacao['endereco_composicao']     = $sChaveEnderecoSeparacao;

        $oOrdemServicoItemSeparacao = TableRegistry::get('OrdemServicoItemSeparacoes')->patchEntity(
            TableRegistry::get('OrdemServicoItemSeparacoes')->newEntity(),
            $aOrdemServicoItemSeparacao
        );

        if (!TableRegistry::get('OrdemServicoItemSeparacoes')->save($oOrdemServicoItemSeparacao)) {
            return $oResponse
                ->setStatus(401)
                ->setMessage('Não foi possível criar o Item de OS, favor validar o inventário!')
                ->setError(EntityUtil::dumpErrors($oOrdemServicoItemSeparacao));
        }

        MovimentacoesEstoque::saveMovimentacao(null, [
            'quantidade_movimentada' => $oOrdemServicoItemSeparacao->qtde_saldo,
            'estoque_id'             => $oOrdemServicoItemSeparacao->estoque_id,
            'endereco_destino_id'    => $oOrdemServicoItemSeparacao->endereco_id,
            'lote'                   => $oOrdemServicoItemSeparacao->lote,
            'serie'                  => $oOrdemServicoItemSeparacao->serie,
            'validade'               => $oOrdemServicoItemSeparacao->validade,
            'created_at_estoque'     => $oOrdemServicoItemSeparacao->created_at,
            'unidade_medida_anterior_id' => $oOrdemServicoItemSeparacao->unidade_medida_id,
            'tipo_movimentacao_id'   => 4
        ]);

        $oOrdemServicoItemSeparacao = TableRegistry::get('OrdemServicoItemSeparacoes')->find()
            ->contain('Enderecos')
            ->where(['OrdemServicoItemSeparacoes.id' => $oOrdemServicoItemSeparacao->id])
            ->first();

        $oOrdemServicoItemSeparacao->endereco->composicao = Endereco::getEnderecoCompletoByID(null, null, $oOrdemServicoItemSeparacao->endereco);

        return $oResponse
            ->setStatus(200)
            ->setMessage('OK')
            ->setDataExtra(['ordem_servico_item_separacao' => $oOrdemServicoItemSeparacao]);
    }
    
    public static function getEnderecosValidosPicking($aDadosOperacao)
    {
        return ArrayUtil::getDepth(self::getEnderecosOrdenados($aDadosOperacao), ['com_heuristica']);
    }
    
    public static function getEnderecosOrdenados($aDadosOperacao)
    {
        return ArrayUtil::getDepth($aDadosOperacao, ['enderecos_ordenados']);
    }

    public static function getItensSeparados($aDadosOperacao)
    {
        $aChavesDeBusca = array_keys(self::getEnderecosValidosPicking($aDadosOperacao));

        if (!$aChavesDeBusca)
            return $aDadosOperacao;

        $aOrdemServicoItemSeparacoes = TableRegistry::get('OrdemServicoItemSeparacoes')->find()
            ->contain('Enderecos')
            ->where([
                'endereco_composicao IN' => $aChavesDeBusca,
                'ordem_servico_id' => $aDadosOperacao['ordem_servico_id']
            ])
            ->toArray();

        if (!$aOrdemServicoItemSeparacoes)
            return $aDadosOperacao;

        $aDadosOperacao = self::setDataItensSeparados($aDadosOperacao, $aOrdemServicoItemSeparacoes);
        
        return $aDadosOperacao;
    }

    public static function setDataItensSeparados($aDadosOperacao, $aOrdemServicoItemSeparacoes)
    {
        foreach ($aOrdemServicoItemSeparacoes as $oOrdemServicoItemSeparacao){
            $oOrdemServicoItemSeparacao->endereco->composicao = Endereco::getEnderecoCompletoByID(null, null, $oOrdemServicoItemSeparacao->endereco);
            $sChaveEnderecoSeparacao = $oOrdemServicoItemSeparacao->endereco_composicao;
            $aDadosOperacao = self::setItemSeparado(
                $aDadosOperacao, 
                $sChaveEnderecoSeparacao,
                $oOrdemServicoItemSeparacao
            );
        }
        return $aDadosOperacao;
    }

    public static function setItemSeparado($aDadosOperacao, $sChaveEnderecoSeparacao, $oOrdemServicoItemSeparacao)
    {
        $aDetalheEndereco = $aDadosOperacao['enderecos_ordenados']['com_heuristica'];

        if (isset($aDetalheEndereco[$sChaveEnderecoSeparacao])) {
            $aDetalheEndereco[$sChaveEnderecoSeparacao]['endereco_separado'] = $oOrdemServicoItemSeparacao->endereco;
            $aDetalheEndereco[$sChaveEnderecoSeparacao]['qtde_separada'] = $oOrdemServicoItemSeparacao->qtde_saldo;
            $aDetalheEndereco[$sChaveEnderecoSeparacao]['ordem_servico_item_separacao'] = $oOrdemServicoItemSeparacao;
            $aDetalheEndereco[$sChaveEnderecoSeparacao]['chave_endereco_separacao'] = $sChaveEnderecoSeparacao;

            $aDadosOperacao['enderecos_ordenados']['informativos']['separados'][$sChaveEnderecoSeparacao] = $aDetalheEndereco[$sChaveEnderecoSeparacao];
            unset($aDadosOperacao['enderecos_ordenados']['com_heuristica'][$sChaveEnderecoSeparacao]);
        }

        //$aDadosOperacao['enderecos_ordenados']['com_heuristica'][$sChaveEnderecoSeparacao] = $aDetalheEndereco[$sChaveEnderecoSeparacao];
        
        return $aDadosOperacao;
    }

    public static function getDadosPosicoes($aOrdemServicoItemSeparacoes)
    {
        // dd($aOrdemServicoItemSeparacoes);
        return $aOrdemServicoItemSeparacoes;
    }
}
