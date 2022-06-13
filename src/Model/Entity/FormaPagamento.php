<?php
namespace App\Model\Entity;

use App\Util\ObjectUtil;
use Cake\ORM\Entity;

/**
 * FormaPagamento Entity
 *
 * @property int $id
 * @property string $descricao
 *
 * @property \App\Model\Entity\EmpresaFormaPagamento[] $empresa_forma_pagamentos
 * @property \App\Model\Entity\FaturamentoBaixa[] $faturamento_baixas
 * @property \App\Model\Entity\Faturamento[] $faturamentos
 */
class FormaPagamento extends Entity
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
        'descricao' => true,
        'empresa_forma_pagamentos' => true,
        'faturamento_baixas' => true,
        'faturamentos' => true
    ];

    public static function getTextGuiaRecebimento($oEmpresa)
    {
        $sParam = ParametroGeral::getParametroWithValue('PARAM_FORMA_PAGAMENTO_TEXTO_RODAPE_FATURAMENTO');
        $aParam = ObjectUtil::getJsonAsArray($sParam, true);

        if (!$aParam || !array_key_exists(@$oEmpresa->tipo_servico_bancario_id, $aParam))
            return '';

        return $aParam[$oEmpresa->tipo_servico_bancario_id];
    }
}
