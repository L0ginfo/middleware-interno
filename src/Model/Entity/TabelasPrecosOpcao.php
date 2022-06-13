<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TabelasPrecosOpcao Entity
 *
 * @property int $id
 * @property int|null $tabela_preco_id
 * @property int|null $tipo_empresa_id
 * @property int|null $empresa_id
 *
 * @property \App\Model\Entity\TabelasPreco $tabelas_preco
 * @property \App\Model\Entity\TiposEmpresa $tipos_empresa
 * @property \App\Model\Entity\Empresa $empresa
 */
class TabelasPrecosOpcao extends Entity
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
        '*' => true,
        'id' => false,
    ];

    public static function getTabelaPrecoClienteByPeriodo($aTabelaPrecos)
    {
        $oTabelaPreco = null;
        $aTabelaPrecosComPeriodoValido = [];
        $aTabelasPrecosSemPeriodo = [];

        foreach ($aTabelaPrecos as $oTabelaPreco) {
            $oTabelaPrecoOpcao = @$oTabelaPreco->_matchingData['TabelasPrecosOpcoes'];

            if (!$oTabelaPrecoOpcao) {
                $aTabelasPrecosSemPeriodo[] = $oTabelaPreco;
                continue;
            }

            if (self::checkPeriodoIsValid($oTabelaPrecoOpcao))
                $aTabelaPrecosComPeriodoValido[] = $oTabelaPreco;
            elseif (!$oTabelaPrecoOpcao->data_inicio)
                $aTabelasPrecosSemPeriodo[] = $oTabelaPreco;
        }


        if ($aTabelaPrecosComPeriodoValido) 
            $oTabelaPreco = $aTabelaPrecosComPeriodoValido[0];
        else
            $oTabelaPreco = @$aTabelasPrecosSemPeriodo[0];

        return $oTabelaPreco;
    }

    private static function checkPeriodoIsValid($oTabelaPrecoOpcao) 
    {
        if (!$oTabelaPrecoOpcao->data_inicio) 
            return false;
        
        $sDatetimeAtual = date('YmdHis');
        $sDatetimeInicio = $oTabelaPrecoOpcao->data_inicio->format('YmdHis');
        $sDatetimeFim = $oTabelaPrecoOpcao->data_fim 
            ? $oTabelaPrecoOpcao->data_fim->format('YmdHis')
            : '';

        if ($sDatetimeInicio <= $sDatetimeAtual && !$sDatetimeFim)
            return true;
        elseif ($sDatetimeInicio <= $sDatetimeAtual && $sDatetimeFim && $sDatetimeFim >= $sDatetimeAtual)
            return true;

        return false;
    }
}
