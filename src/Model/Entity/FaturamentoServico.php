<?php
namespace App\Model\Entity;

use App\Util\DoubleUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

/**
 * FaturamentoServico Entity
 *
 * @property int $id
 * @property float $quantidade
 * @property float $valor_unitario
 * @property float $valor_total
 * @property int $tabela_preco_servico_id
 * @property int $faturamento_id
 * @property int $empresa_id
 *
 * @property \App\Model\Entity\TabelasPrecosServico $tabelas_precos_servico
 * @property \App\Model\Entity\Faturamento $faturamento
 * @property \App\Model\Entity\Empresa $empresa
 */
class FaturamentoServico extends Entity
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
    protected $_accessible = [
        'quantidade' => true,
        'valor_unitario' => true,
        'valor_total' => true,
        'tabela_preco_servico_id' => true,
        'faturamento_id' => true,
        'empresa_id' => true,
        'ordem_servico_servexec_id' => true,
        'servico_id' => true,
        'documento_mercadoria_id' => true,
        'fatura_complementar_com_baixas' => true,
        'ordem_servico_servexec' => true,
        'tabelas_precos_servico' => true,
        'documentos_mercadorias' => true,
        'faturamento' => true,
        'empresa' => true
    ];


    public static function saveItens($iFutamentoId, $aData){
        $aItens = $aData['itens'];

        try {
            if(empty($aItens))  return (new ResponseUtil())->setMessage('Lista de itens está vazia.');
            $aFaturamentoServico = LgDbUtil::getAll('FaturamentoServicos', ['faturamento_id' => $iFutamentoId]);
            $oFaturamento = LgDbUtil::getFirst('Faturamentos', ['id' => $iFutamentoId]);

            $aFaturamentoServico = array_map(function($value) use($aItens){
                if(isset($aItens[$value->id])){
                    $value->quantidade = DoubleUtil::toDBUnformat($aItens[$value->id]['quantidade']);
                    $value->valor_unitario = DoubleUtil::toDBUnformat($aItens[$value->id]['valor_unitario']);
                    $value->valor_total = $value->valor_unitario * $value->quantidade;
                }
                return $value;
            }, $aFaturamentoServico);

            $oResult = LgDbUtil::get('FaturamentoServicos')->saveMany($aFaturamentoServico);

            if(!$oResult) return (new ResponseUtil())->setMessage('Falha ao salvar.');

            $fTotal = array_reduce($aFaturamentoServico, 
                function($sum, $value){ return $sum+$value->valor_total;}, 0);
            $oFaturamento->that['valor_servicos'] = $fTotal;
            $oFaturamento = LgDbUtil::get('Faturamentos')->patchEntity($oFaturamento, $oFaturamento->that);
            $oFaturamento->id = $oFaturamento->that['id'];

            $bSaved = LgDbUtil::save('Faturamentos', $oFaturamento);

            if($bSaved) return (new ResponseUtil())->setStatus(200);

            return (new ResponseUtil())->setMessage('Falha ao salvar alterações faturamento.');

        } catch (\Throwable $th) {
            return (new ResponseUtil())->setMessage($th->getMessage())->setStatus(500);
        }

    }
}
