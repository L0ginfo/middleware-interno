<?php
namespace App\Model\Entity;

use App\Util\EntityUtil;
use App\Util\ObjectUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * EstoqueEnderecoReserva Entity
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
 * @property int $estoque_id
 * @property int $empresa_id
 * @property int|null $produto_id
 * @property int|null $ordem_servico_id
 * @property int|null $estoque_endereco_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\UnidadeMedida $unidade_medida
 * @property \App\Model\Entity\Endereco $endereco
 * @property \App\Model\Entity\Estoque $estoque
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\Produto $produto
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 * @property \App\Model\Entity\EstoqueEndereco $estoque_endereco
 */
class EstoqueEnderecoReserva extends Entity
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
        'estoque_id' => true,
        'empresa_id' => true,
        'produto_id' => true,
        'ordem_servico_id' => true,
        'estoque_endereco_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'unidade_medida' => true,
        'endereco' => true,
        'estoque' => true,
        'empresa' => true,
        'produto' => true,
        'ordem_servico' => true,
        'estoque_endereco' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getQtdEstoqueReservado($uEstoqueEndereco, $bEntregarTotal = true, $aExtraConditions = [], $aOrder = [])
    {
        $dQtdeTotal = 0.0;
        $aQtdeTotalPorEndereco = [];
        $aEstoqueEnderecos = [];
        $aEstoqueEnderecoIDs = [];

        if (!is_array($uEstoqueEndereco))
            $aEstoqueEnderecos = [$uEstoqueEndereco];
        else 
            $aEstoqueEnderecos = $uEstoqueEndereco;

        foreach ($aEstoqueEnderecos as $oEstoqueEndereco) {
            $aEstoqueEnderecoIDs[] = $oEstoqueEndereco->id;
        }
        
        if (!$aEstoqueEnderecoIDs)
            return $dQtdeTotal;
            
        $aEstoqueEnderecoReservas = TableRegistry::get('EstoqueEnderecoReservas')->find()
            ->where([
                'estoque_endereco_id IN' => $aEstoqueEnderecoIDs
            ] + $aExtraConditions)
            ->order($aOrder)
            ->toArray();
        
        foreach ($aEstoqueEnderecoReservas as $key => $oEstoqueEnderecoReserva) {
            $dQtdeTotal += $oEstoqueEnderecoReserva->qtde_saldo;
        }

        if ($bEntregarTotal) {
            return $dQtdeTotal;
        }
        
        foreach ($aEstoqueEnderecoReservas as $key => $oEstoqueEnderecoReserva) {
            @$aQtdeTotalPorEndereco[$oEstoqueEnderecoReserva->estoque_endereco_id] += $oEstoqueEnderecoReserva->qtde_saldo;
        }
        
        return [
            'localizacoes' => $aQtdeTotalPorEndereco,
            'qtde_total_reservada' => $dQtdeTotal
        ];
    }

    public static function setReservaByEstoqueEndereco($aDataSeparacao, $iOSID, $aConditions = [])
    {
        $oResponse = new ResponseUtil();
        $oEstoqueEnderecoReserva = null;
        $oEstoqueEndereco = EstoqueEndereco::getLocalizacaoProdutos($aDataSeparacao, true, $aConditions, [], [], false);
        $oEstoqueEnderecoReservaExistente = self::getReservaExistente($oEstoqueEndereco, $iOSID, $aConditions);
        $oValidadeDate = $oEstoqueEndereco->validade;
        $aEstoqueEndereco = ObjectUtil::getAsArray($oEstoqueEndereco, true);
        $aEstoqueEndereco['validade'] = $oValidadeDate;
        
        unset($aEstoqueEndereco['id']);
        unset($aEstoqueEndereco['created_at']);
        unset($aEstoqueEndereco['updated_at']);
        
        $aEstoqueEndereco['qtde_saldo']          = $aDataSeparacao['qtde'];
        $aEstoqueEndereco['ordem_servico_id']    = $iOSID;
        $aEstoqueEndereco['estoque_endereco_id'] = $oEstoqueEndereco->id;

        if ($oEstoqueEnderecoReservaExistente) {
            $oEstoqueEnderecoReservaExistente->qtde_saldo += $aDataSeparacao['qtde'];
            $oEstoqueEnderecoReserva = $oEstoqueEnderecoReservaExistente;
        }else {
            $oEstoqueEnderecoReserva = TableRegistry::getTableLocator()->get('EstoqueEnderecoReservas')->patchEntity(
                TableRegistry::getTableLocator()->get('EstoqueEnderecoReservas')->newEntity(),
                $aEstoqueEndereco
            );
        }
        
        if (!TableRegistry::getTableLocator()->get('EstoqueEnderecoReservas')->save($oEstoqueEnderecoReserva)){
            return $oResponse
                ->setStatus(401)
                ->setMessage('Não foi possível criar ou agrupar o Endereço de Reserva do Estoque, favor validar o inventário!')
                ->setError(EntityUtil::dumpErrors($oEstoqueEnderecoReserva));
        }

        MovimentacoesEstoque::saveMovimentacao(null, [
            'quantidade_movimentada' => $aDataSeparacao['qtde'],
            'estoque_id'             => $oEstoqueEnderecoReserva->estoque_id,
            'endereco_destino_id'    => $oEstoqueEnderecoReserva->endereco_id,
            'lote'                   => $oEstoqueEnderecoReserva->lote,
            'serie'                  => $oEstoqueEnderecoReserva->serie,
            'validade'               => $oEstoqueEnderecoReserva->validade,
            'created_at_estoque'     => $oEstoqueEnderecoReserva->created_at,
            'unidade_medida_anterior_id' => $oEstoqueEnderecoReserva->unidade_medida_id,
            'status_estoque_id'      => $oEstoqueEnderecoReserva->status_estoque_id,
            'tipo_movimentacao_id'   => 10
        ]);

        return $oResponse
            ->setStatus(200)
            ->setDataExtra(['estoque_endereco_reserva' => $oEstoqueEnderecoReserva]);
    }

    public static function getReservaExistente($oEstoqueEndereco, $iOSID = null, $aConditions = [])
    {
        $aVerifyOS = $iOSID
            ? ['ordem_servico_id' => $iOSID]
            : [];

        $oEstoqueEnderecoReserva = TableRegistry::get('EstoqueEnderecoReservas')->find()
            ->where([
                'produto_id'          => $oEstoqueEndereco->produto_id,
                'unidade_medida_id'   => $oEstoqueEndereco->unidade_medida_id,
                'validade IS'         => $oEstoqueEndereco->validade,
                'lote IS'             => $oEstoqueEndereco->lote,
                'serie IS'            => $oEstoqueEndereco->serie,
                'estoque_id'          => $oEstoqueEndereco->estoque_id,
                'estoque_endereco_id' => $oEstoqueEndereco->id,
                'lote_codigo IS'      => $oEstoqueEndereco->lote_codigo,
                'lote_item is'        => $oEstoqueEndereco->lote_item,
                'qtde_saldo > 0'
            ] + $aVerifyOS + $aConditions)
            ->first();
        
        return $oEstoqueEnderecoReserva;
    }
}
