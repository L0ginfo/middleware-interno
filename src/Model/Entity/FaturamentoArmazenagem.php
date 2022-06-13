<?php
namespace App\Model\Entity;

use App\RegraNegocio\Faturamento\FaturamentoAdicoesManager;
use App\Util\DoubleUtil;
use App\Util\LgDbUtil;
use App\Util\ObjectUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * FaturamentoArmazenagem Entity
 *
 * @property int $id
 * @property int $periodo_dias
 * @property \Cake\I18n\Time $vencimento_periodo
 * @property float $valor_periodo
 * @property int $tab_preco_valida_per_arm_id
 * @property int $faturamento_id
 * @property int $empresa_id
 *
 * @property \App\Model\Entity\TabPrecosValidaPerArm $tab_precos_valida_per_arm
 * @property \App\Model\Entity\Faturamento $faturamento
 * @property \App\Model\Entity\Empresa $empresa
 */
class FaturamentoArmazenagem extends Entity
{
    protected $_accessible = [
        'periodo_dias' => true,
        'vencimento_periodo' => true,
        'valor_periodo' => true,
        'valor_acumulado' => true,
        'tab_preco_valida_per_arm_id' => true,
        'tab_preco_per_arm_id' => true,
        'faturamento_id' => true,
        'empresa_id' => true,
        'isento' => true,
        'numero_periodo' => true,
        'tab_precos_valida_per_arm' => true,
        'tabelas_precos_periodos_arms' => true,
        'faturamento' => true,
        'empresa' => true,
        'valor_periodo_servico' => true,
        'valor_acumulado_servico' => true,
        'valor_total_servico' => true,
        'valor_total_restricao_servico' => true,
        'valor_total_final_servico' => true,
        'valor_periodo_sem_minimo' => true,
        'valor_minimo' => true,
        'valor_retencao' => true,
        'valor_retencao_anterior' => true,
        'valor_total_devido' => true,
        'usa_valor_minimo' => true,
        'acumula_quando_der_valor_minimo' => true,
        'valor_acumulado_no_periodo' => true,
        'valor_periodo_sem_desconto' => true,
        'valor_minimo_sem_desconto' => true,
        'valor_acumulado_sem_desconto' => true,
        'valor_acumulado_servico_sem_desconto' => true,
        'valor_acumulado_no_periodo_sem_desconto' => true,
        'desconto' => true,
        'retencao' => true
    ];
    
    public static function getNumeroPeriodoByArm($iFaturamentoArmID)
    {
        $oFaturamentoArmazenagemTable = TableRegistry::locator()->get('FaturamentoArmazenagens');
        $oFaturamentoArmazenagem = $oFaturamentoArmazenagemTable->find()
            ->where([
                'FaturamentoArmazenagens.id' => $iFaturamentoArmID
            ])
            ->first();

        if ($oFaturamentoArmazenagem)
            return __('Período') . ' ' . $oFaturamentoArmazenagem->numero_periodo;

        return $oFaturamentoArmazenagem;        
    }
}
